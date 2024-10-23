<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Usuarios y Posts</title>
    <style>
        .table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 20px 0; 
        }
        .table th, .table td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
        }
        .table tr:nth-child(even) { 
            background-color: #f2f2f2; 
        }
        .controls { 
            margin: 20px 0;
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .controls select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .controls button {
            padding: 8px 16px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .controls button:hover {
            background: #45a049;
        }
        .form-group { 
            margin-bottom: 15px; 
        }
        .form-group label { 
            display: block; 
            margin-bottom: 5px; 
        }
        .form-group input, .form-group textarea { 
            width: 100%; 
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-actions { 
            margin-top: 20px; 
        }
        .button { 
            padding: 8px 16px; 
            text-decoration: none; 
            color: #333; 
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .edit-record { 
            border: 1px solid #ddd; 
            padding: 15px; 
            margin-bottom: 15px;
            border-radius: 4px;
        }
        /* Estilos para checkbox */
        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            margin-right: 8px;
            vertical-align: middle;
        }
        label {
            cursor: pointer;
            display: inline-flex;
            align-items: center;
        }
        th label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Gestión de Usuarios y Posts</h1>
    <?php echo $bodyOutput; ?>
</body>
</html