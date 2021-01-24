<?php
namespace HHruApi;

/**
 * Class for public vacancies on site hh.ru
 *
 * https://github.com/hhru/api/blob/master/docs/employer_vacancies.md#creation
 */
class VacanciesForPublc
{
    public string $name = '';
    public string $description = '';
    /** string key_skills[].name */
    public array $key_skills = [];
    /** string specializations[].id */
    public array $specializations = [];
    /** string area.id */
    public ?array $area = null;
    /** string type.id */
    public ?array $type = null;
    /** string billing_type.id */
    public ?array $billing_type = ['id' => 'standard'];
    /** string site.id */
    public ?array $site = null;
    public string $code = '';
    /** string department.id */
    public ?array $department = null;
    /**
     * int salary.from
     * int salary.to
     * bool salary.gross
     * bool string.currency
     */
    public ?array $salary = null;
    /**
     * string address.id
     * bool address.show_metro_only
     */
    public ?array $address = null;
    /** string experience.id */
    public ?array $experience = null;
    /** string schedule.id */
    public ?array $schedule = null;
    /** string employment.id */
    public ?array $employment = null;
    /**
     * string contacts.name
     * string contacts.email
     * array contacts.phones
     * string contacts.phones[].country
     * string contacts.phones[].city
     * string contacts.phones[].number
     * string contacts.phones[].comment
     */
    public array $contacts = [
        'name' => '',
        'email' => '',
        'phones' => [],
    ];
    /**
     * string test.id
     * bool test.required
     */
    public ?array $test = null;
    public string $response_url = '';
    public string $custom_employer_name = '';
    /** string manager.id */
    public ?array $manager = null;
    public bool $response_notifications = false;
    public bool $allow_messages = false;
    public bool $response_letter_required = false;
    public bool $accept_handicapped = false;
    public bool $accept_kids = false;
    /** string branded_template.id */
    public ?array $branded_template = null;
    /** string driver_license_types[].id */
    public array $driver_license_types = [];
    public bool $accept_incomplete_resumes = true;
    public array $working_days = [];
    public array $working_time_intervals = [];
    public array $working_time_modes = [];
    public bool $accept_temporary = false;
}