<?php
// HR Team members' data (you can fetch this from a database in real-world applications)
$hr_team = [
    [
        'name' => 'GODFRED AMOAH',
        'title' => 'Director',
        'position' => 'Director of Human Resource',
        'image' => 'uhas_logo.png'
    ],
    [
        'name' => 'MR. GEORGE LOMOTEY',
        'title' => 'Head of Department',
        'position' => 'Recruitment, Promotion & Separation',
        'image' => 'uhas_logo.png'
    ],
    [
        'name' => 'DELALI ADONU',
        'title' => 'Head of Department',
        'position' => 'Compensation & Benefits',
        'image' => 'uhas_logo.png'
    ],
    [
        'name' => 'DORIS MAWUFEMOR ADUKPOH',
        'title' => 'Head of Department',
        'position' => 'Payroll and Benefits',
        'image' => 'uhas_logo.png'
    ],

     [
        'name' => 'EDEM K. EGLE',
        'title' => '',
        'position' => 'Principal Administrative Assistant',
        'image' => 'uhas_logo.png'
    ],
     [
        'name' => 'FREDA LOTSU',
        'title' => '',
        'position' => 'Senior Administrative Assistant',
        'image' => 'Freda.jpg'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Team - University of Health and Allied Sciences</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
        }
        .uhas-header {
            background-color: #006400; /* UHAS Green */
            color: white;
            text-align: center;
            padding: 20px 0;
        }
        .uhas-header h1 {
            font-size: 36px;
        }
        .team-section {
            padding: 40px 0;
        }
        .team-member {
            text-align: center;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            padding: 20px;
        }
        .team-member:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }
        .team-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #FFD700; /* UHAS Yellow */
            margin-bottom: 20px;
            object-fit: cover;
        }
        .team-name {
            font-size: 18px;
            font-weight: 500;
            color: #333;
        }
        .team-title {
            font-size: 16px;
            font-weight: 400;
            color: #555;
        }
        .team-position {
            font-size: 14px;
            font-weight: 300;
            color: #777;
        }
        footer {
            background-color: #006400;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 40px;
        }
        @media (max-width: 768px) {
            .team-member {
                margin-bottom: 30px;
            }
        }
    </style>
</head>
<body>

    <header class="uhas-header">
        <h1>HR Team</h1>
        <p>University of Health and Allied Sciences</p>
    </header>

    <section class="team-section container">
        <div class="row justify-content-center">
            <?php foreach ($hr_team as $member): ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="team-member">
                        <!-- Display image or fallback -->
                        <img src="images/<?= $member['image'] ?>" 
                             onerror="this.src='images/default.jpg';" 
                             alt="<?= $member['name'] ?>" 
                             class="team-image">
                        <div class="team-name"><?= $member['name'] ?></div>
                        <div class="team-title"><?= $member['title'] ?></div>
                        <div class="team-position"><?= $member['position'] ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="home.php" class="btn btn-success">Back to Home</a>
    </section>

    <footer>
        <p>&copy; <?= date("Y"); ?> University of Health and Allied Sciences. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
