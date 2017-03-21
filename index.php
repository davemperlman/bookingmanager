<?php  
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('America/New_York');
include_once 'class.prospect_tracker.php';
$tracker = new Prospect_Tracker();
isset($_GET['submit']) ? $tracker->set_prospect($_GET) : '';
isset($_POST['submit-form']) ? $tracker->update_prospect($_GET) : '';
print_r($tracker->update_prospect($_GET));
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Booking Tracker</title>
		<link rel="stylesheet" href="_css/main.css">
	</head>
	<body>
		<?php if ($tracker->action_needed): ?>
			<table id="attention-table">
				<th>Venue</th>
				<th>Location</th>
				<th>Method</th>
				<th>Comments</th>
				<th>Booked</th>
				<?php foreach ($tracker->action_needed as $key => $value): ?>
					<tr id="attention">
						<td><?php echo $value['name']; ?></td>
						<td><?php echo $value['location']; ?></td>
						<td><?php echo $value['method']; ?></td>
						<td><?php echo $value['comments']; ?></td>
						<td><?php echo $value['booked']; ?></td>
						<td id="update-td">
							<label id="update" for="checkbox">Update</label>
							<input type="checkbox" name="checkbox" id="checkbox">
							<div id="update-form">
								<form method="get">
									<label for="update-method">Latest Contact Method: </label>
									<select name="update-method" id="update-method">
										<option <?php if($value['method'] == 'email') { echo 'selected';} ?> value="email">Email</option>
										<option <?php if($value['method'] == 'phone') { echo 'selected';} ?> value="phone">Phone</option>
										<option <?php if($value['method'] == 'facebook') { echo 'selected';} ?> value="facebook">Facebook</option>
										<option <?php if($value['method'] == 'other') { echo 'selected';} ?> value="other">Other</option>
									</select>
									<label for="update-comments">Update Comments: </label>
									<textarea name="update-comments" id="update-comments"></textarea>
									<input type="checkbox" id="update-booked" name="update-booked">
									<label id="update-book-label" for="update-booked">Booked</label>
									<input type="submit" value="<?php echo $value['id']; ?>" name="submit-form">
									<label for="checkbox" id="close">&#10060;</label>
								</form>
							</div>
						</td>
					</tr>
				<?php endforeach ?>
			</table>
		<?php endif ?>
		<form id="add-prospect" method="get">
			<label for="venue">Venue Name: </label>
			<input type="text" required id="venue" name="venue">
			<label for="location">Location: </label>
			<input type="location" id="location" name="location">
			<label for="method">Contact Method: </label>
			<select name="method" id="method">
				<option value="email">Email</option>
				<option value="phone">Phone</option>
				<option value="facebook">Facebook</option>
				<option value="other">Other</option>
			</select>
			<label for="comments">Comments: </label>
			<textarea name="comments" id="comments"></textarea>
			<input type="checkbox" id="booked" name="booked">
			<label id="book-label" for="booked">Booked</label>
			<input type="submit" name="submit">
		</form>
		<?php if ($tracker->prospects): ?>
			<table>
				<th>Venue</th>
				<th>Location</th>
				<th>Method</th>
				<th>Comments</th>
				<th>Booked</th>
				<?php foreach ($tracker->prospects as $key => $value): ?>
					<tr>
						<td><?php echo $value['name']; ?></td>
						<td><?php echo $value['location']; ?></td>
						<td><?php echo $value['method']; ?></td>
						<td><?php echo $value['comments']; ?></td>
						<td><?php echo $value['booked']; ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		<?php endif ?>
	</body>
</html>