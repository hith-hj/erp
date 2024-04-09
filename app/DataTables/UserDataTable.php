<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    protected $actions = ['newUser'];
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
            ->setRowId('id')
            ->addColumn('Phone',function($user){
              return $user->getSetting('phone_number');
            })
            // ->addColumn('Settings',function($user){
            //   return !is_null($user->settings)?count($user->settings):0;
            // })
            ->addColumn('action',function ($user){
              $lang = __('locale.View');
              return "<a href='show/$user->id'>$lang</a>";
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
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
                    ->setTableId('users_table')
                    ->setTableAttribute('class','table datatables-basic')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->buttons(                        
                        Button::make('pdf')->addClass('btn btn-outline-primary'),
                        Button::make('print')->addClass('btn btn-outline-primary'),
                        Button::make('excel')->addClass('btn btn-outline-primary'),
                        Button::make('copy')->addClass('btn btn-outline-primary'),
                    );
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
            Column::make('username')->title(__('locale.Username')),
            Column::make('full_name')->title(__('locale.Full Name')),
            Column::make('Phone')->title(__('locale.Phone')),
            Column::make('email')->title(__('locale.Email')),
            // Column::make('Settings'),
            // Column::make('created_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(50)
                  ->addClass('text-center')
                  ->title(__('locale.Action')),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Users_' . date('YmdHis');
    }
}
