<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencia</title>
</head>
<body>
    @php
        $days = ["LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES"];
        $iterationCount = 0;
        $firstIteration = true;
    @endphp

    <div style="text-align: center">
        <img src="images/CaraboboLogo.png" style="width: 92.46%; margin: auto;">
    </div>

    <p style="text-align: center;">CONTROL DE ASISTENCIA DEL DÍA ___ AL DÍA ___ DEL MES(es) _____________________</p>
    <table style="border-collapse: collapse; margin: auto;">
    <tr>
        <th style="border: 1px solid black; padding: 4px;">DÍA</th>
        <th style="border: 1px solid black; padding: 4px;">NOMBRE Y APELLIDO</th>
        <th style="border: 1px solid black; padding: 4px;">CÉDULA</th>
        <th style="border: 1px solid black; padding: 4px;">ENTRADA</th>
        <th style="border: 1px solid black; padding: 4px;">SALIDA</th>
        <th style="border: 1px solid black; padding: 4px;">FIRMA</th>
        <th style="border: 1px solid black; padding: 4px;">OBSERVACIÓN</th>
    </tr>
    @while ($iterationCount < count($days))
        @foreach ($persons as $person)
        <tr>
            @if ($firstIteration == true)
                <td style="border: 1px solid black; padding: 4px; text-align:center; font-weight: bold;" rowspan="{{ count($persons) }}">
                    @php
                        $day = $days[$iterationCount];
                        $letter = 0;
                        $letters = mb_str_split($day);
                    @endphp
                    @foreach ($letters as $letter)
                        {{ $letter }} <br> 
                    @endforeach 
                </td>
                @php
                    $firstIteration = false;
                @endphp
            @endif
            <td style="border: 1px solid black; padding: 4px;">{{ $person->person->name . " " . $person->person->lastname}}</td>
            <td style="border: 1px solid black; padding: 4px;">{{ $person->person->dni }}</td>
            <td style="border: 1px solid black; padding: 4px;"></td>
            <td style="border: 1px solid black; padding: 4px;"></td>
            <td style="border: 1px solid black; padding: 4px;"></td>
            <td style="border: 1px solid black; padding: 4px;"></td>
        </tr>    
        @endforeach
        @php
            $firstIteration = true;
            $iterationCount += 1;
        @endphp
    @endwhile
    <tr>
        <td colspan="7" style="border: 1px solid black; padding: 4px;">Observaciones generales: </td>
    </tr>
    </table>
</body>
</html>