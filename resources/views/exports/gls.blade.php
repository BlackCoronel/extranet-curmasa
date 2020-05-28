<table>
    <thead>
    <tr>
        <th>destinatario</th>
        <th>direccion</th>
        <th>c.p</th>
        <th>poblacion</th>
        <th>telefono</th>
        <th>observaciones</th>
        <th>bultos</th>
        <th>kilos</th>
        <th>refC</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pedidos as $pedido)
        <tr>
            <td>{{ $pedido['buyer-name'] }}</td>
            <td>{{ $pedido['ship-address-1'] . ' ' . $pedido['ship-address-2'] . ' ' . $pedido['ship-address-3'] }}</td>
            <td>{{ $pedido['ship-postal-code'] }}</td>
            <td>{{ $pedido['ship-city'] }}</td>
            <td>{{ $pedido['buyer-phone-number'] }}</td>
            <td></td>
            <td>1</td>
            <td>1</td>
            <td>{{ (string) $pedido['refc'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
