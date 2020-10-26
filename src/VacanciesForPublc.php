<?php
namespace HHruApi;

/**
 * Class for public vacancies on site hh.ru
 *
 * https://github.com/hhru/api/blob/master/docs/employer_vacancies.md#creation
 */
class VacanciesForPublc
{
    public $name;
    public $description;
    public $key_skills;
    public $specializations;
    public $area = array('id' => null);
    public $type = array('id' => null);
    public $billing_type = array('id' => null);
    public $site = array('id' => null);
    public $code;
    public $department = array('id' => null);
    public $salary = null;
    public $address = null;
    public $experience = array('id' => null);
    public $schedule = array('id' => null);
    public $employment = array('id' => null);
    public $contacts = array(
        'name' => null,
        'email' => null,
        'phones' => array(),
    );
    public $test = array(
        'id' => null,
        'required' => null
    );
    public $response_url = array(
        'id' => null,
        'required' => null
    );
    public $custom_employer_name = '';
    public $manager = array('id' => null);
    public $response_notifications = false;
    public $allow_messages = false;
    public $response_letter_required = false;
    public $accept_handicapped = false;
    public $accept_kids = false;
    public $branded_template = array('id' => null);
    public $driver_license_types = array();
    public $accept_incomplete_resumes = true;
    public $working_days = array();
    public $working_time_intervals = array();
    public $working_time_modes = array();
    public $accept_temporary = false;
}