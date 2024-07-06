function sendOTP() {
	const email = document.getElementById('email');
	const otpverify = document.getElementsByClassName('otpverify')[0];
	let otp_val = Math.floor(Math.random() * 10000);
	let emailbody = `<h2>Your OTP is </h2>${otp_val}`;
	
	Email.send({
    SecureToken : "d270bb15-bc61-436e-98d9-0f7230290664",
    To : email.value,
    From : "ehrdiabetics@gmail.com",
    Subject : "OTP For Patient User Authentication",
    Body : emailbody,
}).then(

	message => {
		if (message === "OK") {
			alert("OTP sent to your email " + email.value);

			otpverify.style.display = "flex";
			const otp_inp = document.getElementById('otp_inp');
			const otp_btn = document.getElementById('otp-btn');

			otp_btn.addEventListener('click', () => {
				if (otp_inp.value == otp_val) {
					alert("Email address verified...");
					window.location.href = "AuthVerify.php";
				}
				else {
					alert("Invalid OTP");
					window.location.href = "AuthPage.php";
				}
			})
		} else {
			alert("Sorry, email not found or could not be sent.");
			window.location.href = "PatientSignup.php";
		}
	}
);
}