<?php

namespace App\DataTables;

use App\Models\Client;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;

class ClientDataTable extends DataTable
{
  /**
   * Build DataTable class.
   *
   * @param mixed $query Results from query() method.
   * @return \Yajra\DataTables\DataTableAbstract
   */
  public function dataTable($query)
  {
    return datatables()
      ->eloquent($query)
      ->addColumn('name',function($client){
        return $client->full_name;
      })
      ->addColumn('bills',function($client){
        return $client->sales()->count();
      })
      ->addColumn('total',function($client){
        $total = 0;
        foreach($client->sales as $sale){
          $total += $sale->total();
        }
        return $total;
      })
      ->addColumn('created_at',function($client){
        return $client->created_at->diffForHumans();
      })
      ->addColumn('action', function ($client) {
        $view = __('locale.View');
        $options = __('locale.Options');
        return "
                <div class='dropdown'>
                  <button type='button' class='btn btn-sm dropdown-toggle hide-arrow py-0' data-bs-toggle='dropdown'>
                    $options
                  </button>
                  <div class='dropdown-menu dropdown-menu-end'>
                    <a class='dropdown-item' href='/client/show/$client->id'>
                      <i data-feather='edit-2' class='me-50'></i>
                      <span>$view</span>
                    </a>
                  </div>
                </div>";
      });
  }

  /**
   * Get query source of dataTable.
   *
   * @param \App\Models\Client $model
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function query(Client $model)
  {
    return $model->newQuery();
  }

  /**
   * Optional method if you want to use html builder.
   *
   * @return \Yajra\DataTables\Html\Builder
   */
  public function html()
  {
    return $this->builder()
      ->setTableId('client-table')
      ->addTableClass('table-sm')
      ->columns($this->getColumns())
      ->minifiedAjax()
      ->dom('Bfrtip')
      ->orderBy(1)
      ->buttons($this->getBtns());
  }

  public function getBtns()
  {
    $btn_class = 'btn btn-outline-primary btn-sm';
    return [
      Button::make('pdf')->addClass($btn_class),
      Button::make('print')->addClass($btn_class),
      Button::make('excel')->addClass($btn_class),
      Button::make('copy')->addClass($btn_class),
    ];
  }

  /**
   * Get columns.
   *
   * @return array
   */
  protected function getColumns()
  {
    return [
      Column::make('id'),
      Column::make('name')->title(__('locale.Name')),
      Column::make('email')->title(__('locale.Email')),
      Column::make('phone')->title(__('locale.Phone')),
      Column::make('bills')->title(__('locale.Bills')),
      Column::make('total')->title(__('locale.Total')),
      Column::make('created_at')->title(__('locale.Created at')),
      Column::computed('action')
        ->title(__('locale.Action'))
        ->exportable(false)
        ->printable(false)
        ->width(60)
        ->addClass('text-center'),
    ];
  }

  /**
   * Get filename for export.
   *
   * @return string
   */
  protected function filename()
  {
    return 'Client_' . date('YmdHis');
  }
}
