<?php

namespace App\DTO;

class OrganizationDTO
{
    private string $company;
    private string $phone;
    private string $address;

    public function __construct(string $company, string $phone, string $address)
    {
        $this->company = $company;
        $this->phone =$phone;
        $this->address = $address;
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public static function fromArray(array $data): OrganizationDTO
    {
        return new OrganizationDTO(
            company: $data['company'],
            phone: $data['phone'],
            address: $data['address']
        );
    }

}
