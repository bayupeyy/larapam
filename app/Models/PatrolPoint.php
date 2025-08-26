<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PatrolPoint extends Model
{
    use HasFactory;

    protected $fillable = ['name','location','qr_code','qr_code_path'];

    // Pastikan file QR dibuat saat record dibuat / disimpan
    protected static function boot()
    {
        parent::boot();

        // Saat membuat record baru
        static::creating(function (PatrolPoint $m) {
            self::ensureQrAssets($m);
        });

        // Untuk data lama yang belum punya qr_code_path
        static::saving(function (PatrolPoint $m) {
            if (empty($m->qr_code_path)) {
                self::ensureQrAssets($m);
            }
        });
    }

    protected static function ensureQrAssets(PatrolPoint $m): void
    {
        // Pakai UUID jika belum ada
        if (empty($m->qr_code)) {
            $m->qr_code = (string) Str::uuid();
        }

        // Generate SVG agar TIDAK perlu imagick
        $svg = QrCode::format('svg')
            ->size(512)
            ->margin(0)
            ->generate($m->qr_code);

        $path = "qr_codes/{$m->qr_code}.svg";
        Storage::disk('public')->put($path, $svg);

        $m->qr_code_path = $path;
    }

    // Relasi (opsional)
    // public function schedules(){ return $this->hasMany(PatrolSchedule::class); }
}
