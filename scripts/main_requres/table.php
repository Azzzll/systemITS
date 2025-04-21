<!-- Table -->
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="dataTable">
    
        <?php
        if ($_SESSION['role_id'] == 1){
        $result = mysqli_query($db, "SHOW COLUMNS FROM requests");
        $columns = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $columns[] = $row['Field'];
        }
        $stmt = $db->prepare("SELECT request_id, user_id, topic, priority, status, created_at FROM requests WHERE user_id = ?");        
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows > 0) {
            echo '<style>
                .requests-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                    font-family: Arial, sans-serif;
                }
                .requests-table th, .requests-table td {
                    border: 1px solid #ddd;
                    padding: 12px;
                    text-align: left;
                }
                .requests-table th {
                    background-color: #f2f2f2;
                    font-weight: bold;
                }
                .requests-table tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                .requests-table tr:hover {
                    background-color: #f1f1f1;
                }
            </style>';
            
            echo '<table class="table table-bordered table-striped">';
            echo '<thead><tr>';
            echo '<th>№</th>';
            echo '<th>Тема</th>';
            echo '<th>Дата создания</th>';
            echo '<th>Статус</th>';
            echo '<th>Исполнитель</th>';

            echo '</tr></thead>';
            echo '<tbody>';
            
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['request_id']) . '</td>';
                echo '<td>' . htmlspecialchars($row['topic']) . '</td>';
                echo '<td>' . htmlspecialchars($row['created_at']) . '</td>';
                echo '<td>' . htmlspecialchars($row['status']) . '</td>';

                echo '<td>' . htmlspecialchars($row['priority']) . '</td>';
                echo '</tr>';
            }
            
            echo '</tbody></table>';
            
        }

    }
        ?>
</div>