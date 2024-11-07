@extends('admin.layout')

@section('title','Report page')

@section('content')

<div class="row p-1">
    <div class="col-12">
        <div class="card p-2">
            <table class="table table-sm" id="example1">
                <thead>
                    <tr>
                        <th>View</th>
                        <th>Card id</th>
                        <th>Name</th>
                        <th>invoice</th>
                        <th>Nationality</th>
                        <th>Package</th>
                        <th>Strat training</th>
                        <th>End Training</th>
                        <th>Create by</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td><a href="" class="btn btn-sm btn-info">view</a></td>
                            <td>{{ $item->m_card }}</td>
                            <td>{{ $item->fname }}</td>
                            <td>{{ $item->invoice }}</td>
                            <td>{{ $item->nationalty }}</td>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->sta_date }}</td>
                            <td>{{ $item->exp_date }}</td>
                            {{-- <td>{{ \Carbon\Carbon::parse($item->sta_date)->locale('th')->translatedFormat('d M Y') }}</td> --}}
                            {{-- <td>{{ \Carbon\Carbon::parse($item->exp_date)->locale('th')->translatedFormat('d M Y') }}</td> --}}
                            <td>{{ $item->AddBy }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
