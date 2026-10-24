<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Author</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }
        .container {
            width: 100%;
            max-width: 900px;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        h1 {
            margin-bottom: 20px;
            color: #2c3e50;
            border-bottom: 2px solid #eef2f5;
            padding-bottom: 10px;
            font-size: 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            overflow: hidden;
            border-radius: 8px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
        }
        th {
            background-color: #3b82f6;
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }
        tr {
            border-bottom: 1px solid #eef2f5;
            transition: background-color 0.2s ease;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        tr:hover {
            background-color: #f1f5f9;
        }
        td:first-child {
            font-weight: bold;
            color: #64748b;
            text-align: center;
            width: 60px;
        }
        .photo-tag {
            background-color: #e2e8f0;
            padding: 4px 8px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 12px;
            color: #475569;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar Author</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Author</th>
                    <th>Foto</th>
                    <th>Bio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($authors as $author)
                    <tr>
                        <td>{{ $author['id'] }}</td>
                        <td>{{ $author['name'] }}</td>
                        <td><span class="photo-tag">{{ $author['photo'] }}</span></td>
                        <td>{{ $author['bio'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>