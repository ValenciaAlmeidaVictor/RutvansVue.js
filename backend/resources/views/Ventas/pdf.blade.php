<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Venta {{ $venta->folio }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .venta-details {
            margin-bottom: 20px;
        }
        .venta-details th, .venta-details td {
            padding: 8px;
            border: 1px solid #ccc;
        }
        .venta-details th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h2>Detalles de la Venta</h2>

    <div class="venta-details">
        <table>
            <tr>
                <th>ID Venta</th>
                <td>{{ $venta->id }}</td>
            </tr>
            <tr>
                <th>Folio</th>
                <td>{{ $venta->folio }}</td>
            </tr>
            <tr>
                <th>Fecha</th>
                <td>{{ $venta->date }}</td>
            </tr>
            <tr>
                <th>Cliente</th>
                <td>{{ $user ? $user->name : 'No disponible' }}</td>
            </tr>
            <tr>
                <th>Estado</th>
                <td>{{ $state }}</td>
            </tr>
            <tr>
                <th>Método de Pago</th>
                <td>{{ $method }}</td>
            </tr>
            <tr>
                <th>Total</th>
                <td>${{ number_format($venta->cost, 2) }}</td>
            </tr>
        </table>
    </div>

</body>
</html>
