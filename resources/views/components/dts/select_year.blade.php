<select class="custom-select form-select" id="admin_year" onchange="load_graph(this)">
    <?php for ($i = 2023; $i <= 2030; $i++) {

    $selected = $i == date('Y') ? "selected" : "";

    echo '<option ' . $selected . '>' . $i . '</option>';

} ?>
</select>