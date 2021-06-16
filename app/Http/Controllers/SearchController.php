<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anounces;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class SearchController extends Controller
{
    public function search(Request $request)
    {

        $caracteristics = null;
        $display        = null;
        $values         = null;
        $room           = null;
        $room_value     = null;
        $order_by_value = null;
        $order_by       = null;
        $what_value     = null;

        if (!$request->has('province_rent') ||  $request->input('province_rent') == 'Donde' ||  $request->input('province_rent') == '') {
            $mensaje = 'Por favor indique una provincia para la busqueda';
            return redirect()->route('home')->with(['statuss_' => $mensaje]);
        }


        $province = $request->input('province_rent');
        $q = Anounces::where('province_rent', Str::lower($province));
        //$cookieProvince = cookie('province_rent', $search, 30 * 24 * 60);
        //seteamos una cookie para rellenar el form de busqueda como lo tenia el user

        if (Cookie::has('province_rent')) {
            Cookie::queue(Cookie::forget('province_rent'));
        }

        Cookie::queue('province_rent', $province, 7 * 24 * 60);


        if ($request->has('caracteristics') && $request->input('caracteristics') != '' && $request->input('caracteristics') != 'Caracteristicas') {
            $caracteristics = $request->input('caracteristics');

            $search = false;

            if ($caracteristics == 'Amueblado')   $search = 'funiture';

            if ($caracteristics == 'Calefacción') $search = 'calefaction';

            if ($caracteristics == 'Gas')         $search = 'gas';

            if ($caracteristics == 'Piscina')     $search = 'swiming';

            if ($caracteristics == 'Fumador')     $search = 'lookfor_who_tabaco';

            if ($caracteristics == 'Mascotas')    $search = 'lookfor_who_pet';

            if ($search) {
                $anounce = $q->where($search, 1);
            }


            if (Cookie::has('caracteristics')) {
                Cookie::queue(Cookie::forget('caracteristics'));
            }


            Cookie::queue('caracteristics', $caracteristics, 7 * 24 * 60);
        }

        if ($request->has('price') && $request->input('price') != '' && $request->input('price') != 'Precio' && $request->input('price') != '0') {

            $values = $request->input('price');
            $value = explode('-', $values);
            $type = $value[0];
            $min  = $value[1];
            $max  = $value[2];

            if ($min == '1') {
                $display = 'Menos de ' . $max . '€ - ' . ucfirst($type);
            } elseif ($type == 'alquiler' && $max > '1300') {
                $display = 'Mas de 1300€ - ' . ucfirst($type);
            } elseif ($type == 'venta' && $max > '2000000') {
                $display = 'Mas de 200.000€ - ' . ucfirst($type);
            } else {
                $display =  $min . '€ a ' . $max . '€ - ' . ucfirst($type);
            }

            $anounce = $q->whereBetween('price', [$min, $max])->where('type', $type);


            if (Cookie::has('price')) {
                Cookie::queue(Cookie::forget('price'));
                Cookie::queue(Cookie::forget('value_price'));
            }


            Cookie::queue('price', $display, 7 * 24 * 60);
            Cookie::queue('value_price', $values, 7 * 24 * 60);
        }

        if ($request->has('room') && $request->input('room') != '' && $request->input('room') != 'Habitaciones' && $request->input('room') != '0') {
            $room_value = $request->input('room');

            $room = $room_value == '1' ? 'Habitación' : 'Habitaciones';
            $room = $room_value . ' ' . $room;

            $anounce = $q->where('num_rooms', $room_value);

            if (Cookie::has('room')) {
                Cookie::queue(Cookie::forget('room'));
                Cookie::queue(Cookie::forget('room_value'));
            }

            Cookie::queue('room', $room, 7 * 24 * 60);
            Cookie::queue('room_value', $room_value, 7 * 24 * 60);
        }

        if ($request->has('what') && $request->input('what') != '' && $request->input('what') != 'Que buscas' && $request->input('what') != '0') {

            $what_value = $request->input('what');

            $room = $room_value == '1' ? 'Habitación' : 'Habitaciones';
            $room = $room_value . ' ' . $room;

            if ($what_value != 'Todo') $anounce = $q->where('type_rent', $what_value);

            if (Cookie::has('what_value')) {

                Cookie::queue(Cookie::forget('what_value'));
            }

            Cookie::queue('what_value', $what_value, 7 * 24 * 60);
        }

        if ($request->has('order_by') && $request->input('order_by') != '' && $request->input('order_by') != 'Ordenar por' && $request->input('order_by') != '0') {
            $order_by_value = $request->input('order_by');

            if ($order_by_value == '1') {
                $anounce = $q->orderBy('price', 'ASC');
                $order_by = 'Precio mas bajo';
            } elseif ($order_by_value == '2') {
                $anounce = $q->orderBy('price', 'DESC');
                $order_by = 'Precio mas alto';
            } else {
                $anounce = $q->orderBy('id', 'DESC');
                $order_by = 'Ordenado por';
                $order_by_value = 0;
            }

            if (Cookie::has('order_by_value')) {
                Cookie::queue(Cookie::forget('order_by'));
                Cookie::queue(Cookie::forget('order_by_value'));
            }


            Cookie::queue('order_by', $order_by, 7 * 24 * 60);
            Cookie::queue('order_by_value', $order_by_value, 7 * 24 * 60);
        }


        $anounce = $q->paginate(10);

        $selections = DB::table('anounces');

        if ($province) $selections = $selections->where('province_rent', '=', $province);

        $selections = $selections->limit(4);
        $selections = $selections->join('images', 'anounces_id', '=', 'anounces.id', 'left');
        $selections = $selections->inRandomOrder();
        $selections = $selections->get();

        if ($anounce == null) {

            $mensaje = 'Fallo en la busqueda, intentelo de nuevo';
            return redirect()->route('home')->with(['statuss_' => $mensaje]);
        }

        return view('search.search', [
            'anuncios'       => $anounce,
            'selections'     => $selections,
            'geoCity'        => false,
            'search'         => false,
            'province'       => $province,
            'caracteristics' => $caracteristics,
            'price'          => $display,
            'value_price'    => $values,
            'room_value'     => $room_value,
            'room'           => $room,
            'order_by_value' => $order_by_value,
            'order_by'       => $order_by,
            'what_value'     => $what_value,

        ]);
    }
}