<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siniestros', function (Blueprint $table) {
            $table->id();
            $table->integer("ID_BITACORA");
            $table->string("NRO");
            $table->string("NUM_SINI");
            $table->string("EST_EXP");
            $table->string("PROVINCIA_OCURRENCIA");
            $table->string("FEC_SINI");
            $table->string("FEC_APERTURA");
            $table->string("TIP_VEHI_SINIESTRO");
            $table->string("MATRICULA");
            $table->string("DSC_MARCA");
            $table->string("DSC_MODELO");
            $table->string("ANIO_FAB");
            $table->string("TIP_VEHI");
            $table->string("SUMA_ASEG");
            $table->string("DSC_TERCERO");
            $table->string("NOM_PERITO_ASIG");
            $table->string("NOM_EJECUTIVO");
            $table->string("FEC_PETICION");
            $table->string("FEC_ENTRADA");
            $table->string("FEC_AUTORIZACION");
            $table->string("FEC_ENTREGA_EST");
            $table->float("NUM_DIAS_REP",8,2);
            $table->string("TOTAL");
            $table->string("TIP_EST_INSP");
            $table->string("MCA_PERD_TOTAL");
            $table->string("AUTO_WEB");
            $table->string("TIP_EXP");
            $table->integer("COD_MON");
            $table->string("TIP_MARCACION");
            $table->string("NUM_POLIZA_GRUPO");
            $table->string("NUM_POLIZA");
            $table->string("NOM_MOD");
            $table->string("NOM_OFICINA");
            $table->string("TIP_DOCUM_ASEG");
            $table->string("COD_DOCUM_ASEG");
            $table->string("NOMBRE");
            $table->string("USO");
            $table->string("LUGAR");
            $table->string("FEC_SAL_TALLER");
            $table->string("TLF_ASEG1");
            $table->string("TLF_ASEG2");
            $table->string("OFIC");
            $table->string("AGT");
            $table->string("NOM_PROCURADOR");
            $table->string("MCA_PAR");
            $table->string("P_DSCTO_PRONTO_PAGO");
            $table->string("TIPO_PERITACION");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siniestros');
    }
};
