<?php

use Illuminate\Database\Seeder;
use App\Models\Skema;
use App\Models\Dana;
use App\Models\Event;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $last = Carbon::today()->addDay();
        foreach (Skema::all() as $skema){
            foreach (Dana::all() as $dana){
                Event::create([
                    'skema_id' => $skema->id,
                    'dana_id' => $dana->id,
                    'tgl_mulai_pendaftaran' => $last->toDateTimeString(),
                    'tgl_akhir_pendaftaran' => $last->addDays(2)->copy()->addHours(23)->addMinutes(59)->addSeconds(59)->toDateTimeString(),
                    'tgl_uji' => $last->addDay()->copy()->addHours(8)->toDateTimeString()
                ]);
            }
        }

        $events = Event::whereHas('getDana', function ($query) {
            $query->where('nama', '!=', 'Mandiri');
        })->get();

        foreach ($events as $event){
            $event->tgl_mulai_pendaftaran = $event->tgl_mulai_pendaftaran->addMonths(-4)->toDateTimeString();
            $event->tgl_akhir_pendaftaran = $event->tgl_akhir_pendaftaran->addMonths(-4)->toDateTimeString();
            $event->tgl_uji = $event->tgl_uji->addMonths(-4)->toDateTimeString();
            $event->save();
        }
    }
}
