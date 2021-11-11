<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampleModerationLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sample_moderation_labels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('confidence', 4,2);
            $table->unsignedBigInteger('sample_id');
            $table->foreign('sample_id', 'fk_moderation_sample')
                ->references('id')
                ->on('samples');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sample_moderation_labels');
    }
}
