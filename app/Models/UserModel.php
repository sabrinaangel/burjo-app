<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * UserModel - Model untuk mengelola data user/admin
 */
class UserModel extends Model
{
    // Nama tabel di database
    protected $table = 'users';
    
    // Primary key
    protected $primaryKey = 'id';
    
    // Tipe return data
    protected $returnType = 'array';
    
    // Field yang boleh diisi
    protected $allowedFields = [
        'name',
        'email', 
        'password',
        'role'
    ];
    
    // Timestamps otomatis
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    // Validasi
    protected $validationRules = [
        'email'    => 'required|valid_email',
        'password' => 'required|min_length[6]',
    ];
}