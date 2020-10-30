<?php
namespace HHruApi;

/**
 * Class with queries parameters for vacancies searches
 *
 * https://github.com/hhru/api/blob/master/docs/employer_vacancies.md#active
 */
class VacanciesQueryActive
{
    public string $manager_id = '';
    public string $text = '';
    public ?int $area = null;
    public ?string $order_by = null;
    public int $per_page = 100;
    public int $page = 1;
}