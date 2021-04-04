<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\BillboardTypeRepository;

use function PHPSTORM_META\map;

class BillboardTypeService extends Service
{
  public function __construct(
    Request $request,
    BillboardTypeRepository $repository
  ) {
    $this->request = $request;
    $this->repository = $repository;
  }

  public function create($adminId)
  {
    // 檢查重複名稱
    $this->throwJobFailed(
      '名稱重複',
      !$this->repository->find(['name' => $this->parameter['name'], 'isDeleted' => 0])->first()
    );

    $this->getCreator($adminId);
    $this->parameter['sequence'] = $this->parameter['sequence'] ?? 1;

    $this->repository->create($this->parameter);
  }

  public function show()
  {
    // 分頁預設值
    $this->getPaginationParam([1, 10]);
    // 排序預設值
    $this->getOrder(['ASC', 'id']);

    $data = $this->repository->show($this->parameter);
    $data['list'] = $data['list']->map(function ($item) {
      return [
        'id' => $item->id,
        'name' => $item->name,
        'sequence' => $item->sequence,
        'updatedBy' => $item->updatedBy,
        'createdOn' => $item->createdOn,
        'updatedOn' => $item->updatedOn
      ];
    });

    return $data;
  }

  public function read($id)
  {
    $data = $this->findExist($id);

    return [
      'id' => $data->id,
      'name' => $data->name,
      'sequence' => $data->sequence,
      'isEnabled' => (bool) $data->isEnabled,
      'updatedByName' => $data->updateByName->name,
      'updatedOn' => $data->updatedOn
    ];
  }

  public function update($id, $adminId)
  {
    // 檢查重複名稱
    if ($id != $this->repository->find(['name' => $this->parameter['name']])->pluck('id')->first()) {
      $this->throwJobFailed('名稱重複');
    }

    $this->getEditor($adminId);
    $this->parameter['sequence'] = $this->parameter['sequence'] ?? 1;

    $this->repository->update(['id' => $id], $this->parameter);
  }

  public function delete($id)
  {
    // 取得資料是否存在
    $data = $this->repository->find(['id' => $id]);

    // 確認是否停用
    if ($data->pluck('isEnabled')->first()) {
      $this->throwJobFailed('未停用，無法刪除');
    }

    // 軟刪除
    $this->repository->update(['id' => $id], ['isDeleted' => 1]);
  }
}
