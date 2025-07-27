<?php

namespace App\Domains\Pharmacy\Dtos;

class MedicineDto
{
    public function __construct(
        public string $medicineId,
        public string $medicineName,
        public string $groupName,
        public int $stockInQty
    ) {}
}
