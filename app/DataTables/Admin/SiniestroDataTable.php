<?php

namespace App\DataTables\Admin;

use Datatables;
use App\Models\Siniestro;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class SiniestroDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
        ->eloquent($query)
        ;
    }
    
    public function query(Siniestro $model): QueryBuilder
    { 		
		return $model->newQuery();	
    }


    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('SiniestrosDatatable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'paging' => true,
                'lengthMenu' => [[10, 20, 50, 100], [10, 20, 50, 100]],
                'searchDelay' => 1000,
            ])
            ->language([
                'url' => url('assets/json/datatable-es.json'),
            ])
            ->dom('
                <"row me-2"
                <"col-md-2"<"me-3"l>>
                <"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>
                >t
                <"row mx-2"
                <"col-sm-12 col-md-6"i>
                <"col-sm-12 col-md-6"p>
                >')
            ->orderBy(0)
            ->buttons(
                Button::make([])
                    ->extend('collection')
                    ->className('btn btn-label-secondary dropdown-toggle mx-3')
                    ->text('<i class="ti ti-screen-share me-1 ti-xs"></i>Exportar')
                    ->buttons([
                        Button::make('excel')
                            ->className('dropdown-item')
                            ->text('<span><i class="ti ti-file-spreadsheet me-2"></i>Excel</span>')
                            ->exportOptions(['modifier' => ['page' => 'all']]),
                    ]),

                 
            );
    }

    public function getColumns(): array
    {
        return [
            
            Column::make('created_at')
                ->title('Fecha Carga'),
				 				
			Column::make('NUM_SINI')
                ->title('siniestro'),
						
			Column::make('MATRICULA')
                ->title('placa') ,
			
			Column::make('FEC_ENTREGA_EST')
                ->title('FEC_ENTREGA_EST') ,		

			Column::make('NOM_PERITO_ASIG')
                ->title('perito') ,
			
			Column::make('DSC_TERCERO')
                ->title('taller') ,
				 
			Column::make('NOTIFICADO')
                ->title('NOTIFICADO') ,	
				
			Column::make('MCA_PAR')
                ->title('es virtual')  
				 
				 
						
 
        ];
    }

    protected function filename(): string
    {
        return 'Siniestros_' . date('YmdHis');
    }
}
