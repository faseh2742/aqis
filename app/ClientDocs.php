<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientDocs extends Model
{
    use HasFactory;
    protected $table='clientdocuments';
    protected $fillable = [
        'doc_name',
        'doc_file',
        'client_id',
        'user_id'

    ];
}
