<?php namespace LLPM;

use LLPM\Repositories\SettingRepository;

class IdGenerator {

	protected $settingRepository;

	function __construct(SettingRepository $settingRepository)
	{
		$this->settingRepository = $settingRepository;
	}

	public function generateWorkOrderNo()
	{
		//get latest ID
		$workOrderNo = $this->settingRepository->getAll()->first()->work_order_no;

		// increment ID by 1
		$this->settingRepository->incrementWorkOrderNo();

		return $workOrderNo;
	}
	
	public function generateImportDlNo()
	{
		//get latest ID
		$dlNo = $this->settingRepository->getAll()->first()->import_dl_no;

		// increment ID by 1
		$this->settingRepository->incrementImportDlNo();

		return $dlNo;
	}

	public function generateExportDlNo()
	{
		//get latest ID
		$dlNo = $this->settingRepository->getAll()->first()->export_dl_no;

		// increment ID by 1
		$this->settingRepository->incrementExportDlNo();

		return $dlNo;
	}

}