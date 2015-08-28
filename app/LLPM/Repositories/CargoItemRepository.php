<?php namespace LLPM\Repositories;

use CargoItem;

class CargoItemRepository {

	public function save(CargoItem $cargoItem)
	{
		$cargoItem->save();
		return $cargoItem;
	}

	public function getAll()
	{
		return CargoItem::all();
	}

	public function getById($id)
	{
		return CargoItem::with('cargo')->find($id);
	}
	
	public function getAllByCargoId($cargo_id)
	{
		return CargoItem::with('cargo', 'customTariff')
			->where('cargo_id', $cargo_id)
			->orderBy('custom_tariff_code')
			->get();		
	}

}