<?php
namespace App\Http\Controllers\Services;
use Illuminate\Http\Request;
use App\Models\Good;

interface GoodServiceInterface
{
    public function createGood (Request $data);
    public function listGoods (int $inventoryId);
    public function listGoodsWithAttributes (int $inventoryId);
        
    public function listGoodsAttributes(int $inventoryId);
    public function checkInventoryAttribute(int $inventoryId);
    public function getInventoryAttributeKeys();
    public function updateGoodStatus(int $goodId, string $status);
}