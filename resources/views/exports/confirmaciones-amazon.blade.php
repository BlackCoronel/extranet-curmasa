<table>
    <thead>
    <tr>
        <th>order-id</th>
        <th>order-item-id</th>
        <th>quantity</th>
        <th>ship-date</th>
        <th>carrier-code</th>
        <th>carrier-name</th>
        <th>tracking-number</th>
        <th>ship-method</th>
        <th>transparency_code</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pedidos as $pedido)
        <tr>
            <td>{{ $pedido['order-id'] }}</td>
            <td>{{ $pedido['order-item-id'] }}</td>
            <td>{{ $pedido['quantity-to-ship'] }}</td>
            <td>{{ date('Y-m-d') }}</td>
            <td>GLS</td>
            <td></td>
            <td>{{ $pedido['numero_seguimiento'] }}</td>
            <td>Estándar</td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
