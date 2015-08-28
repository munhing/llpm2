<?php namespace LLPM\Forms;

use Laracasts\Validation\FormValidator;
use Laracasts\Validation\FormValidationException;

class ImportCargoForm extends FormValidator{

	protected $rules = [
		'bl_no' 	=> 'required|unique:cargoes',
		'consignor_id'  => 'required',
		'consignee_id'  => 'required',
		'mt'  => 'required',
		'm3'  => 'required'
	];

	protected $changeAttributes = [];

	public function validate($formData)
	{
		$formData = $this->normalizeFormData($formData);

		$this->validation = $this->validator->make(
			$formData,
			$this->getValidationRules(),
			$this->getValidationMessages()
		);

		// Change the name of the fields when displaying errors
		$this->validation->setAttributeNames($this->getChangeAttributes());

		if ($this->validation->fails())
		{
			throw new FormValidationException('Validation failed', $this->getValidationErrors());
		}

		return true;
	}

    public function validateUpdate(array $input, $id)
    {
        $this->rules['bl_no'] .= ',bl_no,'.$id;
        return $this->validate($input);
    }
    
	public function getChangeAttributes()
	{
		return $this->changeAttributes;
	}
}