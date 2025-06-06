@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs | IMSP Séminaires</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --soft-lavender: #f0e6ff;
            --gentle-mint: #e0f7e6;
            --deep-lilac: #8a4fff;
            --misty-rose: #fce4ec;
            --soft-violet: #d8c0ff;
            --light-periwinkle: #e6e6ff;
            --soft-gray: #f9f9fb;
            --dark-purple: #3a2e6d;
            --shadow-soft: 0 8px 30px rgba(0, 0, 0, 0.08);
            --border-radius: 18px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Nunito', sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--soft-lavender) 0%, var(--gentle-mint) 100%);
            min-height: 100vh;
            color: #4a4a6a;
            line-height: 1.6;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 100px 20px 60px;
        }

        .header {
            margin-bottom: 40px;
            position: relative;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--dark-purple);
            position: relative;
            display: inline-block;
        }

        .header h1::after {
            content: "";
            position: absolute;
            bottom: -12px;
            left: 0;
            width: 120px;
            height: 5px;
            background: var(--deep-lilac);
            border-radius: 3px;
        }

        .header p {
            color: #6c6c8a;
            font-size: 1.1rem;
            margin-top: 15px;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-radius: var(--border-radius);
            padding: 35px;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 255, 255, 0.6);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: 0 15px 40px rgba(138, 79, 255, 0.15);
            transform: translateY(-5px);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 14px;
            margin-bottom: 25px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.95rem;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            color: #15803d;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            color: #b91c1c;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .alert i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .table-container {
            overflow-x: auto;
            border-radius: 16px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 800px;
        }

        thead {
            background: rgba(138, 79, 255, 0.1);
        }

        th {
            padding: 18px 20px;
            text-align: left;
            font-weight: 700;
            color: var(--dark-purple);
            font-size: 0.95rem;
            border-bottom: 2px solid rgba(138, 79, 255, 0.2);
        }

        tbody tr {
            background: rgba(255, 255, 255, 0.7);
            transition: var(--transition);
        }

        tbody tr:hover {
            background: rgba(138, 79, 255, 0.05);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        td {
            padding: 20px;
            border-bottom: 1px solid rgba(224, 214, 255, 0.4);
            color: #5a5a7a;
            font-size: 0.95rem;
        }

        .capitalize {
            text-transform: capitalize;
        }

        .role-form {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
        }

        .role-select {
            border: 2px solid #e0d6ff;
            border-radius: 14px;
            padding: 10px 15px;
            font-size: 0.95rem;
            background: white;
            color: var(--dark-purple);
            font-weight: 500;
            width: 160px;
            transition: var(--transition);
            outline: none;
        }

        .role-select:focus {
            border-color: var(--deep-lilac);
            box-shadow: 0 0 0 3px rgba(138, 79, 255, 0.2);
        }

        .update-btn {
            padding: 10px 20px;
            background: linear-gradient(135deg, var(--deep-lilac) 0%, #6c2fff 100%);
            border: none;
            border-radius: 14px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(138, 79, 255, 0.25);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
        }

        .update-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(138, 79, 255, 0.4);
        }

        .cannot-update {
            color: #a0a0c0;
            font-style: italic;
            text-align: center;
            font-size: 0.9rem;
        }

        .decoration {
            position: fixed;
            z-index: -1;
            border-radius: 50%;
            opacity: 0.5;
            pointer-events: none;
        }

        .dec-1 {
            top: 10%;
            left: 5%;
            width: 120px;
            height: 120px;
            background: var(--misty-rose);
        }

        .dec-2 {
            bottom: 15%;
            right: 7%;
            width: 100px;
            height: 100px;
            background: var(--light-periwinkle);
        }

        .dec-3 {
            top: 30%;
            right: 10%;
            width: 80px;
            height: 80px;
            background: var(--soft-violet);
        }

        @media (max-width: 768px) {
            .container {
                padding: 80px 15px 40px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .card {
                padding: 25px;
            }
            
            .role-form {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .role-select {
                width: 100%;
            }
            
            .update-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Decorations -->
    <div class="decoration dec-1"></div>
    <div class="decoration dec-2"></div>
    <div class="decoration dec-3"></div>

    <div class="container">
        <div class="header">
            <h1>Gestion des utilisateurs</h1>
            <p>Modifiez les rôles et accès des utilisateurs du système</p>
        </div>

        <div class="card">
            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif
            
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle actuel</th>
                            <th>Changer le rôle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="font-semibold text-gray-900">
                                    {{ $user->name }}
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td class="capitalize">
                                    {{ $user->role }}
                                </td>
                                <td>
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.updateRole', $user->id) }}" class="role-form">
                                            @csrf
                                            @method('PUT')
                                            <select name="role" class="role-select" required>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>
                                                        {{ ucfirst($role) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="update-btn">
                                                <i class="fas fa-sync-alt"></i> Mettre à jour
                                            </button>
                                        </form>
                                    @else
                                        <div class="cannot-update">
                                            Impossible de modifier
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Animation au survol des lignes
        document.querySelectorAll('tbody tr').forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.02)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });

        // Animation des boutons
        document.querySelectorAll('.update-btn').forEach(btn => {
            btn.addEventListener('mousedown', () => {
                btn.style.transform = 'translateY(1px)';
                btn.style.boxShadow = '0 2px 8px rgba(138, 79, 255, 0.25)';
            });
            
            btn.addEventListener('mouseup', () => {
                btn.style.transform = 'translateY(-3px)';
                btn.style.boxShadow = '0 8px 25px rgba(138, 79, 255, 0.4)';
            });
        });
    </script>
</body>
</html>
@endsection
