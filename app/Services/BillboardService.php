<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\BillboardRepository;
use App\Repositories\BillboardTypeRepository;
use App\Repositories\BillboardReaderRepository;
use App\Repositories\AdminRepository;

class BillboardService extends Service
{
    public function __construct(
        Request $request,
        AdminRepository $adminRepo,
        BillboardRepository $repository,
        BillboardTypeRepository $billboardTypeRepo,
        BillboardReaderRepository $billboardReaderRepo
    ) {
        $this->request = $request;
        $this->repository = $repository;
        $this->adminRepo = $adminRepo;
        $this->billboardTypeRepo = $billboardTypeRepo;
        $this->billboardReaderRepo = $billboardReaderRepo;
    }

    public function create($adminId)
    {
        // 檢查 typeId 是否存在
        $this->throwJobFailed('typeId 不存在', $this->billboardTypeRepo->find(['id' => $this->parameter['typeId']], 'id')->first());

        $this->getCreator($adminId);

        // 新增公佈欄
        $billboard = $this->repository->create($this->parameter);

        // 新增閱讀人員
        foreach ($this->parameter['readers'] as $reader) {
            $this->billboardReaderRepo->create([
                'billboardId' => $billboard->id,
                'readerId' => $reader,
                'createdBy' => $adminId,
                'updatedBy' => $adminId,
            ]);
        }

        return;
    }

    public function show($adminId)
    {
        // 分頁預設值
        $this->getPaginationParam([1, 10]);
        // 排序預設值
        $this->getOrder(['ASC', 'id']);

        $data = $this->repository->show($adminId, $this->parameter);

        $data['list'] = $data['list']->map(function ($item) {
            return [
                'id' => $item->id,
                'typeId' => $item->typeId,
                'title' => $item->title,
                'updatedOn' => $item->updatedOn,
                'updatedBy' => $item->updatedBy,
            ];
        });

        return $data;
    }

    public function read($id, $adminId)
    {
        $data = $this->findExist($id);

        // 取得閱讀人員
        $readers = $this->billboardReaderRepo->find(['billboardId' => $id])->pluck('readerId')->all();

        // 檢查權限
        if (!in_array($adminId, $readers)) {
            $this->throwJobFailed('無權限');
        }

        return [
            'typeId' => $data->typeId,
            'title' => $data->title,
            'content' => $data->content,
            'readers' => $readers,
            'updateByName' => $data->updateByName->name
        ];
    }

    public function update($id, $adminId)
    {
        $data = $this->findExist($id);

        // 取得閱讀者人員
        $readers = $data->readers()->pluck('readerId')->all();

        // 檢查權限
        if (!in_array($adminId, $readers)) {
            $this->throwJobFailed('無權限');
        }

        // 檢查 typeId 權限
        dd($this->BillboardTypeRepository->getId($this->parameter['typeId'])->where(['isEnabled' => 0]));
        $this->getEditor($adminId);
        $this->repository->update(['id' => $id], [
            'typeId' => $this->parameter['typeId'],
            'title' => $this->parameter['title'],
            'content' => $this->parameter['content'],
            'updatedBy' => $adminId,
        ]);
    }

    // 檢查使用者權限
    private function checkAdminId($adminId)
    {
        $data = $this->adminRepo->find($adminId);
    }
}
