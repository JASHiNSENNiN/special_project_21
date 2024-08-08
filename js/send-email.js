import React, { useRef } from "react";
import emailjs from "@emailjs/browser";

export const Contact = () => {
  const form = useRef();

  const sendEmail = (e) => {
    e.preventDefault();

    emailjs
      .sendForm("YOUR_SERVICE_ID", "YOUR_TEMPLATE_ID", form.current, {
        publicKey: "YOUR_PUBLIC_KEY",
      })
      .then(
        () => {
          console.log("SUCCESS!");
        },
        (error) => {
          console.log("FAILED...", error.text);
        }
      );
  };

  return (
    // <form ref={form} onSubmit={sendEmail}>
    //   <label> Name </label> <input type="text" name="user_name" />
    //   <label> Email </label> <input type="email" name="user_email" />
    //   <label> Message </label> <textarea name="message" />
    //   <input type="submit" value="Send" />
    // </form>
    <form ref={form} onSubmit={sendEmail} autocomplete="off">
      <div class="input-box">
        <input
          pattern="[A-Za-z]{3,10}"
          minlength="3"
          maxlength="10"
          oninvalid="setCustomValidity('Please enter on alphabets only. ')"
          type="text"
          id="name"
          placeholder="Enter your name"
          required
        />
      </div>{" "}
      <div class="input-box">
        <input type="text" id="email" placeholder="Enter your email" required />
      </div>{" "}
      <div class="input-box message-box">
        <textarea id="message" placeholder="Enter your message"></textarea>{" "}
      </div>{" "}
      <div>
        <button class="sub-button" type="submit">
          Send Now{" "}
        </button>{" "}
      </div>{" "}
    </form>
  );
};
