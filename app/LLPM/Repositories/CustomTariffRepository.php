<?php 

namespace LLPM\Repositories;

use CustomTariff;

class CustomTariffRepository {

	public function getAll()
	{
		return CustomTariff::all();
	}

	public function getByCode($code)
	{
		return CustomTariff::where('code', $code)->first();
	}

    public function getById($id)
    {
        return CustomTariff::find($id);
    }
}