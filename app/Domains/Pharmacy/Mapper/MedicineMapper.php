<?php

namespace App\Domains\Pharmacy\Mapper;

use App\Domains\Pharmacy\Dtos\MedicineDto;

use App\Domains\Pharmacy\Models\Product;

class MedicineMapper
{
    public static function fromProduct(Product $product): MedicineDto
    {
        return new MedicineDto(
            medicineId: (string) $product->id,
            medicineName: $product->name,
            groupName: $product->brand ?? 'N/A',
            stockInQty: (int) $product->stock
        );
    }

    public static function toArray(MedicineDto $dto): array
    {
        return [
            'medicineId' => $dto->medicineId,
            'medicineName' => $dto->medicineName,
            'groupName' => $dto->groupName,
            'stockInQty' => $dto->stockInQty,
        ];
    }
}
