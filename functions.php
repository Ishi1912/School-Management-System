<?php
// Functions for managing fees

// Add a fee record for a student
function addFee($conn, $sid, $amount, $due_date) {
    $sql = "INSERT INTO fees (sid, amount, due_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sds", $sid, $amount, $due_date);
    if ($stmt->execute()) {
        return "Fee record added successfully!";
    } else {
        return "Error: " . $stmt->error;
    }
}

// Fetch fee records for a specific student
function getFees($conn, $sid) {
    $sql = "SELECT * FROM fees WHERE sid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $sid);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Mark a fee as paid
function markFeeAsPaid($conn, $fid) {
    $sql = "UPDATE fees SET status = 'Paid', payment_date = CURDATE() WHERE fid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $fid);
    if ($stmt->execute()) {
        return "Fee marked as paid!";
    } else {
        return "Error: " . $stmt->error;
    }
}
?>
