<div class="card-body">
    <div class="table-responsive">
        <table id="ul-contact-list" class="display table table-striped table-sm pb-2" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center"><strong>No</strong></th>
                    <th class="text-center"><strong>Invoice</strong></th>
                    <th class="text-center"><strong>Event</strong></th>
                    <th class="text-center"><strong>Tipe</strong></th>
                    <th class="text-center"><strong>Price</strong></th>
                    <th class="text-center"><strong>Status Pembayaran</strong></th>
                    <th class="text-center"><strong>Tanggal Daftar</strong></th>
                </tr>
            </thead>
            <tbody>

                @foreach($registrations as $d)
                <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td>{{ $d->invoice }}</td>
                    <td>{{ $d->event->eventDetail->title }}</td>
                    <td>{{ $d->event->event_type }}</td>
                    <td>{{ $d->total_price }}</td>
                    <td>{{ !is_null($d->paid_at) ? "PAID" : "UNPAID" }}</td>
                    <td>{{ $d->created_at }}</td>
                </tr>
                @endforeach

            </tbody>

        </table>
    </div>

</div>
