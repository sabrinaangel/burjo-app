<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * SettingsModel - Model untuk mengambil pengaturan aplikasi
 * (password WiFi, gambar QRIS, dll)
 */
class SettingsModel extends Model
{
    protected $table      = 'settings';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = ['key', 'value'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Ambil nilai setting berdasarkan key
    public function getSetting(string $key): ?string
    {
        $row = $this->where('key', $key)->first();
        return $row ? $row['value'] : null;
    }

    // Update nilai setting
    public function setSetting(string $key, string $value): void
    {
        $existing = $this->where('key', $key)->first();
        if ($existing) {
            $this->update($existing['id'], ['value' => $value]);
        } else {
            $this->insert(['key' => $key, 'value' => $value]);
        }
    }
}