<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Tutor extends Model
{
    protected $table = 'tutores';

    protected $fillable = [
        'nome',
        'cpf',
        'telefone',
        'email',
    ];

    public function getCpfDescriptografadoAttribute(): string
    {
        try {
            return Crypt::decryptString($this->cpf);
        } catch (\Throwable $e) {
            if (str_starts_with((string) $this->cpf, 'ENC_AES256:')) {
                return base64_decode(str_replace('ENC_AES256:', '', $this->cpf));
            }
            return (string) $this->cpf;
        }
    }

    public function pets()
    {
        return $this->hasMany(Pet::class, 'tutor_id');
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'tutor_id');
    }
}