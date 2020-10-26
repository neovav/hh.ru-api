<?php
namespace HHruApi;

/**
 * Class with queries parameters for vacancies searches
 *
 * https://github.com/hhru/api/blob/master/docs/vacancies.md#search
 */
class VacanciesQuery
{
    public $text;
    public $search_field;
    public $experience;
    public $employment;
    public $schedule;
    public $area;
    public $metro;
    public $specialization;
    public $industry;
    public $employer_id;
    public $currency;
    public $salary;
    public $label;
    public $only_with_salary = false;
    public $period;
    public $date_from;
    public $date_to;
    public $top_lat;
    public $bottom_lat;
    public $left_lng;
    public $right_lng;
    public $order_by;
    public $sort_point_lat;
    public $sort_point_lng;
    public $clusters = false;
    public $describe_arguments = false;
    public $per_page;
    public $page;
    public $no_magic = false;
    public $premium = false;
    public $responses_count_enabled = false;
    public $part_time = false;
}