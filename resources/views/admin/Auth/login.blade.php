<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Goalf Foundation · animated admin sign in</title>
    <!-- Fonts & Icons (same robust stack) -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
      rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" />
    <style>
      /* ----- RESET & FULL BLEED (unchanged) ----- */
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      html,
      body {
        height: 100%;
        overflow: hidden;
        font-family: 'Public Sans', sans-serif;
      }
      body {
        background: #fafafa;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
      }

      /* ===== PROFESSIONAL ANIMATION BACKGROUND – now with floating bubbles & paw icons (more vibrant) ===== */
      .animation-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        background: radial-gradient(circle at 30% 40%, #ffeede, #f2f0f5);
        overflow: hidden;
      }
      /* extra bubble / paw friendly particles (new, more lively) */
      .bubble {
        position: absolute;
        background: rgba(180, 200, 220, 0.2);
        border-radius: 60% 40% 50% 50%;
        filter: blur(16px);
        animation: bubbleFloat 18s infinite alternate ease-in-out;
      }
      .bubble1 {
        width: 280px;
        height: 280px;
        top: 5%;
        left: -30px;
        background: rgba(230, 200, 180, 0.25);
      }
      .bubble2 {
        width: 400px;
        height: 400px;
        bottom: -100px;
        right: 5%;
        background: rgba(210, 230, 250, 0.3);
        animation-duration: 24s;
        filter: blur(40px);
      }
      .bubble3 {
        width: 200px;
        height: 200px;
        top: 60%;
        left: 15%;
        background: rgba(250, 220, 200, 0.3);
        animation-duration: 14s;
        filter: blur(24px);
      }
      .bubble4 {
        width: 340px;
        height: 340px;
        top: 10%;
        right: 20%;
        background: rgba(190, 220, 190, 0.2);
        animation-duration: 30s;
      }

      /* icon bubbles: dog/doctor/hospital icons that float upward with bubble motion */
      .icon-bubble {
        position: absolute;
        bottom: -120px;
        left: var(--x, 50%);
        width: var(--size, 74px);
        height: var(--size, 74px);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: rgba(80, 80, 80, 0.78);
        background:
          radial-gradient(circle at 28% 26%, rgba(255, 255, 255, 0.95), rgba(220, 240, 255, 0.5) 45%, rgba(185, 210, 230, 0.24));
        box-shadow:
          inset 0 0 18px rgba(255, 255, 255, 0.65),
          0 14px 22px -12px rgba(0, 0, 0, 0.2);
        filter: blur(0.15px);
        animation:
          iconBubbleRise var(--dur, 18s) linear infinite,
          iconBubbleSway calc(var(--dur, 18s) * 0.24) ease-in-out infinite;
        animation-delay: var(--delay, 0s);
        z-index: 1;
      }

      .icon-bubble i {
        font-size: calc(var(--size, 74px) * 0.42);
        filter: drop-shadow(0 4px 7px rgba(255, 255, 255, 0.8));
        opacity: 0.9;
      }

      @keyframes iconBubbleRise {
        0% {
          transform: translate3d(0, 0, 0) scale(0.85);
          opacity: 0;
        }
        10% {
          opacity: 0.55;
        }
        80% {
          opacity: 0.5;
        }
        100% {
          transform: translate3d(var(--drift, 40px), -118vh, 0) scale(1.18);
          opacity: 0;
        }
      }

      @keyframes iconBubbleSway {
        0%,
        100% {
          margin-left: -7px;
        }
        50% {
          margin-left: 8px;
        }
      }

      @keyframes bubbleFloat {
        0% {
          transform: translate(0, 0) scale(1);
          opacity: 0.4;
        }
        100% {
          transform: translate(40px, -30px) scale(1.2);
          opacity: 0.7;
        }
      }

      /* floating paw / medical icons – more dynamic */
      .floating-particle {
        position: absolute;
        opacity: 0.3;
        filter: drop-shadow(0 8px 12px rgba(0, 0, 0, 0.08));
        animation: orbit 20s infinite alternate;
        color: #5f5f5f;
        font-size: 3.8rem;
        z-index: 1;
      }
      .particle-1 {
        top: 12%;
        left: 18%;
        animation-duration: 16s;
      }
      .particle-2 {
        bottom: 18%;
        right: 8%;
        font-size: 5rem;
        animation-duration: 22s;
      }
      .particle-3 {
        top: 70%;
        left: 12%;
        animation-duration: 18s;
      }
      .particle-4 {
        top: 25%;
        right: 30%;
        font-size: 4.2rem;
        animation-duration: 25s;
      }
      .particle-5 {
        bottom: 28%;
        left: 40%;
        animation-duration: 14s;
      }
      .particle-6 {
        top: 8%;
        right: 8%;
        animation-duration: 20s;
      }
      .particle-7 {
        bottom: 8%;
        right: 40%;
        font-size: 4.5rem;
        animation-duration: 28s;
      }
      .particle-8 {
        top: 45%;
        left: 5%;
        animation-duration: 19s;
      }
      .particle-9 {
        bottom: 45%;
        right: 5%;
        animation-duration: 21s;
      }

      @keyframes orbit {
        0% {
          transform: rotate(-8deg) translateY(0px) scale(0.95);
        }
        50% {
          transform: rotate(8deg) translateY(-25px) scale(1.1);
        }
        100% {
          transform: rotate(-5deg) translateY(10px) scale(1);
        }
      }

      .blob {
        position: absolute;
        background: rgba(190, 190, 190, 0.1);
        border-radius: 70% 30% 60% 40%;
        width: 500px;
        height: 500px;
        left: -150px;
        bottom: -100px;
        animation: blobMove 32s infinite alternate;
        filter: blur(60px);
      }
      .blob2 {
        width: 600px;
        height: 600px;
        right: -200px;
        top: -150px;
        left: auto;
        bottom: auto;
        background: rgba(160, 200, 210, 0.12);
        animation: blobMove 28s infinite alternate-reverse;
      }
      @keyframes blobMove {
        0% {
          transform: translate(0, 0) scale(1);
        }
        100% {
          transform: translate(80px, -70px) scale(1.3);
        }
      }

      /* main card (same structure) */
      .authentication-wrapper {
        position: relative;
        z-index: 20;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        height: 100vh;
      }
      .authentication-inner {
        max-width: 1120px;
        width: 100%;
        background: rgba(255, 255, 255, 0.78);
        backdrop-filter: blur(18px) saturate(180%);
        border-radius: 48px;
        box-shadow:
          0 35px 70px -20px rgba(0, 0, 0, 0.3),
          0 0 0 1px rgba(255, 255, 255, 0.5) inset;
        border: 1px solid rgba(255, 255, 255, 0.5);
        display: flex;
        flex-wrap: wrap;
        overflow: hidden;
        animation: cardGlow 6s infinite alternate;
      }
      @keyframes cardGlow {
        0% {
          box-shadow:
            0 35px 70px -20px rgba(90, 90, 90, 0.3),
            0 0 0 1px rgba(255, 255, 240, 0.8) inset;
        }
        100% {
          box-shadow:
            0 35px 80px -15px #5f5f5f,
            0 0 0 3px rgba(220, 220, 255, 0.6) inset;
        }
      }

      /* LEFT SIDE – 100% PRESERVED (EXACTLY AS ORIGINAL, no changes) */
      .left-animated-panel {
        width: 50%;
        background: transparent;
        padding: 2rem 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        min-height: 540px;
      }
      .animated-dog-container {
        position: relative;
        width: 100%;
        max-width: 380px;
        margin: 0 auto;
      }
      .main-dog-icon {
        font-size: 14rem;
        line-height: 1;
        text-align: center;
        color: #4e4e4e;
        filter: drop-shadow(0 12px 16px rgba(80, 80, 80, 0.25));
        animation: dogWag 3.5s infinite alternate ease-in-out;
        transform-origin: bottom;
        display: block;
      }
      @keyframes dogWag {
        0% {
          transform: rotate(-3deg) scale(1);
        }
        100% {
          transform: rotate(5deg) scale(1.03);
        }
      }
      .float-icon {
        position: absolute;
        background: white;
        width: 62px;
        height: 62px;
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow:
          0 18px 28px -10px rgba(0, 0, 0, 0.2),
          0 0 0 2px rgba(255, 255, 255, 0.7);
        animation: floatLoop 6s infinite alternate;
        backdrop-filter: blur(5px);
        color: #5f5f5f;
        font-size: 2.2rem;
      }
      .ficon-left-1 {
        top: 0;
        left: 0;
        animation-delay: 0s;
        background: #fdf4e7;
      }
      .ficon-left-2 {
        top: 15%;
        right: 0;
        animation-delay: 1.2s;
        background: #e8f0fe;
      }
      .ficon-left-3 {
        bottom: 5%;
        left: 5%;
        animation-delay: 2.4s;
        background: #f0f7e8;
      }
      .ficon-left-4 {
        bottom: 25%;
        right: 5%;
        animation-delay: 0.8s;
        background: #fee9e7;
      }
      @keyframes floatLoop {
        0% {
          transform: translateY(0) rotate(0deg);
        }
        100% {
          transform: translateY(-20px) rotate(12deg);
        }
      }
      .left-bg-particles i {
        position: absolute;
        font-size: 1.8rem;
        color: #b8b8b8;
        opacity: 0.25;
        animation: slowSpin 14s infinite;
      }
      .left-bg-particles i:nth-child(1) {
        top: 60%;
        left: 10%;
      }
      .left-bg-particles i:nth-child(2) {
        top: 30%;
        left: 70%;
      }
      .left-bg-particles i:nth-child(3) {
        top: 80%;
        left: 50%;
      }
      @keyframes slowSpin {
        0% {
          transform: rotate(0deg) scale(1);
        }
        50% {
          transform: rotate(180deg) scale(1.2);
        }
        100% {
          transform: rotate(360deg) scale(1);
        }
      }

      /* ========== RIGHT SIDE – COMPLETELY REVAMPED, PERFECT & FULLY ANIMATED ========== */
      .right-form-panel {
        width: 50%;
        padding: 2.6rem 2.4rem;
        border-left: 2px solid rgba(160, 160, 160, 0.2);
        display: flex;
        align-items: center;
      }
      .form-container {
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
      }

      /* utility classes used in markup (bootstrap is not included in this file) */
      .d-flex {
        display: flex;
      }
      .justify-content-between {
        justify-content: space-between;
      }
      .justify-content-center {
        justify-content: center;
      }
      .align-items-center {
        align-items: center;
      }
      .gap-2 {
        gap: 0.5rem;
      }
      .mt-4 {
        margin-top: 1rem;
      }
      .mb-3 {
        margin-bottom: 0.75rem;
      }
      .mb-0 {
        margin-bottom: 0;
      }

      /* --- logo with sophisticated levitate + glow --- */
      .goalf-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 2rem;
        animation: logoReveal 0.8s cubic-bezier(0.2, 0.9, 0.3, 1.1);
      }
      .logo-icon {
        background: #5f5f5f;
        width: 54px;
        height: 54px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        color: white;
        box-shadow: 0 14px 18px -8px #5f5f5f;
        animation: softRing 3.5s infinite ease-in-out;
      }
      .logo-text {
        font-size: 2.1rem;
        font-weight: 700;
        color: #222;
        animation: textGlow 1s;
      }
      .logo-text span {
        font-weight: 400;
        color: #6f6f6f;
      }
      @keyframes logoReveal {
        0% {
          opacity: 0;
          transform: translateX(-34px) scale(0.9);
        }
        100% {
          opacity: 1;
          transform: translateX(0) scale(1);
        }
      }
      @keyframes softRing {
        0% {
          box-shadow: 0 14px 18px -8px #5f5f5f;
        }
        50% {
          box-shadow:
            0 14px 28px -2px #3f3f3f,
            0 0 0 4px rgba(255, 255, 240, 0.4);
          transform: scale(1.02);
        }
        100% {
          box-shadow: 0 14px 18px -8px #5f5f5f;
        }
      }
      @keyframes textGlow {
        0% {
          opacity: 0;
          letter-spacing: -2px;
          filter: blur(1px);
        }
        100% {
          opacity: 1;
          letter-spacing: normal;
          filter: blur(0);
        }
      }

      /* headings with smooth slide + spring */
      h4 {
        font-size: 1.9rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.35rem;
        animation: slideUp 0.7s ease-out;
      }
      .subhead {
        color: #4f4f4f;
        margin-bottom: 1.5rem;
        font-size: 1rem;
        border-left: 4px solid #ababab;
        padding-left: 12px;
        animation: slideUp 0.8s;
      }
      @keyframes slideUp {
        0% {
          opacity: 0;
          transform: translateY(24px);
        }
        100% {
          opacity: 1;
          transform: translateY(0);
        }
      }

      /* fields – modern animated border & label */
      .mb-4 {
        position: relative;
        margin-bottom: 1rem;
        animation: fieldStagger 0.5s backwards;
      }
      .mb-4:nth-of-type(1) {
        animation-delay: 0.1s;
      }
      .mb-4:nth-of-type(2) {
        animation-delay: 0.2s;
      }
      @keyframes fieldStagger {
        0% {
          opacity: 0;
          transform: translateX(16px);
        }
        100% {
          opacity: 1;
          transform: translateX(0);
        }
      }

      .form-label {
        font-weight: 600;
        color: #3d3d3d;
        display: inline-block;
        transition: all 0.2s;
        transform-origin: left;
        margin-bottom: 6px;
      }
      .form-control {
        background: rgba(255, 255, 255, 0.8);
        border: 2px solid #c9c9c9;
        border-radius: 26px;
        padding: 0.75rem 1.2rem;
        min-height: 48px;
        font-size: 1rem;
        transition:
          border-color 0.2s,
          box-shadow 0.3s,
          transform 0.2s;
        width: 100%;
      }
      .form-control:focus {
        border-color: #7a7a7a;
        box-shadow: 0 0 0 8px rgba(122, 122, 122, 0.12);
        background: #ffffff;
        transform: scale(1.01) translateY(-2px);
        animation: inputPulse 0.6s ease-out;
      }

      /* bootstrap is not loaded in this standalone page, so define input-group behavior explicitly */
      .input-group,
      .input-group-merge {
        display: flex;
        align-items: stretch;
        width: 100%;
      }

      .form-password-toggle .input-group {
        overflow: hidden;
        border-radius: 26px;
      }

      .form-password-toggle .input-group .form-control {
        flex: 1 1 auto;
        min-width: 0;
        border-right: none;
        border-radius: 26px 0 0 26px;
        transform: none;
      }

      .form-password-toggle .input-group:focus-within .form-control,
      .form-password-toggle .input-group:focus-within .input-group-text {
        border-color: #7a7a7a;
      }
      @keyframes inputPulse {
        0% {
          box-shadow: 0 0 0 0 rgba(122, 122, 122, 0.3);
        }
        70% {
          box-shadow: 0 0 0 10px rgba(122, 122, 122, 0);
        }
      }

      /* password toggle with extra fun */
      .input-group-text {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 56px;
        min-height: 48px;
        background: rgba(255, 255, 255, 0.8);
        border: 2px solid #c9c9c9;
        border-left: none;
        border-radius: 0 26px 26px 0;
        padding: 0;
        transition:
          background 0.2s,
          color 0.2s,
          transform 0.2s;
        cursor: pointer;
        line-height: 1;
      }
      .input-group-text:hover {
        background: #eaeaea;
        color: #2f2f2f;
        transform: none;
      }
      .input-group-text i {
        font-size: 1.15rem;
        transition:
          transform 0.3s,
          opacity 0.2s;
      }
      .input-group-text:hover i {
        transform: scale(1.2) rotate(8deg);
      }

      /* checkbox & forgot row */
      .my-4 {
        margin: 1rem 0 1.1rem;
        animation: fadeMove 0.6s 0.3s backwards;
      }
      @keyframes fadeMove {
        0% {
          opacity: 0;
          transform: translateY(8px);
        }
        100% {
          opacity: 1;
          transform: translateY(0);
        }
      }
      .form-check-input {
        width: 18px;
        height: 18px;
        accent-color: #7a7a7a;
        cursor: pointer;
        transition:
          transform 0.2s,
          box-shadow 0.2s,
          border-color 0.2s;
      }
      .form-check {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
      }
      .form-check-label {
        margin: 0;
        line-height: 1;
      }
      .form-check-input:checked {
        transform: scale(1.15);
        box-shadow: 0 0 0 4px rgba(95, 95, 95, 0.15);
        border-color: #5f5f5f;
      }
      .form-check-label {
        transition:
          color 0.2s,
          font-weight 0.2s;
      }
      .form-check-input:checked + .form-check-label {
        color: #3f3f3f;
        font-weight: 600;
      }
      .forgot-link {
        color: #5f5f5f;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s;
        display: inline-block;
      }
      .forgot-link:hover {
        color: #2c2c2c;
        transform: translateX(2px);
        text-decoration: underline wavy #aaa 1px;
      }

      /* sign in button – outstanding animation with bounce, shine, pulse */
      .btn-primary {
        background: #5f5f5f;
        border: none;
        border-radius: 40px;
        padding: 0.86rem;
        font-weight: 600;
        font-size: 1.1rem;
        line-height: 1.2;
        box-shadow: 0 18px 28px -12px #5f5f5f;
        transition: all 0.25s;
        width: 100%;
        animation:
          btnPop 0.9s 0.4s backwards,
          btnSoftPulse 3s infinite 0.9s;
        cursor: pointer;
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        position: relative;
        overflow: hidden;
      }
      .btn-primary::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -60%;
        width: 200%;
        height: 200%;
        background: linear-gradient(
          to right,
          rgba(255, 255, 255, 0) 0%,
          rgba(255, 255, 255, 0.3) 50%,
          rgba(255, 255, 255, 0) 100%
        );
        transform: rotate(25deg);
        animation: shine 5s infinite linear;
      }
      @keyframes shine {
        0% {
          transform: translateX(-100%) rotate(25deg);
        }
        20% {
          transform: translateX(100%) rotate(25deg);
        }
        100% {
          transform: translateX(200%) rotate(25deg);
        }
      }
      @keyframes btnPop {
        0% {
          opacity: 0;
          transform: scale(0.86) translateY(18px);
        }
        80% {
          transform: scale(1.02) translateY(-2px);
        }
        100% {
          opacity: 1;
          transform: scale(1) translateY(0);
        }
      }
      @keyframes btnSoftPulse {
        0% {
          box-shadow: 0 16px 28px -12px #3f3f3f;
        }
        50% {
          box-shadow:
            0 22px 38px -8px #2f2f2f,
            0 0 0 2px rgba(255, 255, 255, 0.2);
          transform: scale(1.02);
        }
        100% {
          box-shadow: 0 16px 28px -12px #3f3f3f;
        }
      }
      .btn-primary:hover {
        background: #3b3b3b;
        transform: translateY(-6px) scale(1.03);
        box-shadow: 0 30px 36px -12px #2f2f2f;
      }
      .btn-primary:active {
        transform: translateY(4px) scale(0.98);
      }

      /* create account link */
      .text-center {
        animation: revealDelay 1s 0.5s backwards;
      }
      @keyframes revealDelay {
        0% {
          opacity: 0;
        }
        100% {
          opacity: 1;
        }
      }
      .text-center a {
        transition: all 0.2s;
        font-weight: 600;
      }
      .text-center a:hover {
        color: #1a1a1a;
        text-decoration: underline;
        padding-left: 8px;
        letter-spacing: 0.3px;
      }

      /* divider with running dashes + glow text */
      .divider {
        text-align: center;
        margin: 1.8rem 0;
        position: relative;
        animation: dividerFade 1.2s 0.7s backwards;
      }
      .divider-text {
        background: rgba(255, 255, 255, 0.6);
        display: inline-block;
        padding: 0 1rem;
        color: #5f5f5f;
        font-weight: 500;
        position: relative;
        z-index: 2;
        animation: softBreathing 4s infinite;
      }
      .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #b0b0b0, #b0b0b0, transparent);
        z-index: 1;
        animation: dashFlow 4.5s infinite linear;
        background-size: 200% 100%;
      }
      @keyframes dashFlow {
        0% {
          background-position: 100% 0;
        }
        100% {
          background-position: -100% 0;
        }
      }
      @keyframes softBreathing {
        0% {
          opacity: 0.9;
          text-shadow: 0 0 2px #ccc;
        }
        50% {
          opacity: 1;
          text-shadow: 0 0 6px #aaa;
          letter-spacing: 1px;
        }
        100% {
          opacity: 0.9;
          text-shadow: 0 0 2px #ccc;
        }
      }
      @keyframes dividerFade {
        0% {
          opacity: 0;
          transform: scale(0.95);
        }
        100% {
          opacity: 1;
          transform: scale(1);
        }
      }

      /* social icons – with bouncy, rotating, magnetic group effect */
      .d-flex.justify-content-center {
        animation: socialPop 1s 0.8s backwards;
        gap: 10px;
      }
      .btn-icon {
        background: #f2f2f2;
        border: 1px solid #c0c0c0;
        color: #5f5f5f;
        width: 48px;
        height: 48px;
        border-radius: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        transition: all 0.3s cubic-bezier(0.18, 0.89, 0.32, 1.28);
        margin: 0 2px;
      }
      .btn-icon:hover {
        background: #e2e2e2;
        transform: translateY(-8px) rotate(10deg) scale(1.22);
        box-shadow: 0 18px 22px -8px #8f8f8f;
        border-color: #7a7a7a;
        color: #3f3f3f;
      }
      @keyframes socialPop {
        0% {
          opacity: 0;
          transform: scale(0.7) translateY(14px);
        }
        100% {
          opacity: 1;
          transform: scale(1) translateY(0);
        }
      }

      /* extra badge on left preserved but we add a tiny animation (left side remains untouched, but badge is inside left panel, so allowed? badge was already there – we keep left side 100% including its own badge, no changes) */
      /* the left badge animation existed before, we do not modify it. but we keep it intact – it's original code. */

      /* responsiveness */
      @media (max-width: 992px) {
        .left-animated-panel {
          display: none;
          width: 0;
          min-height: 0;
          padding: 0;
        }

        .right-form-panel {
          width: 100%;
          border-left: 0;
          padding: 1.4rem 1rem;
        }

        .authentication-inner {
          border-radius: 26px;
          max-width: 520px;
        }

        .authentication-wrapper {
          padding: 0.8rem;
        }

        .icon-bubble {
          display: none;
        }
      }
    </style>
  </head>
  <body>
    <!-- background – now enriched with extra bubbles / paw icons (still respects left side) -->
    <div class="animation-bg">
      <div class="blob"></div>
      <div class="blob blob2"></div>
      <!-- additional lively bubbles (dog/medical atmosphere) -->
      <div class="bubble bubble1"></div>
      <div class="bubble bubble2"></div>
      <div class="bubble bubble3"></div>
      <div class="bubble bubble4"></div>
      <!-- icon bubbles moving with bubble flow -->
      <div class="icon-bubble" style="--x: 6%; --size: 66px; --dur: 17s; --delay: -4s; --drift: 44px">
        <i class="bx bxs-dog"></i>
      </div>
      <div class="icon-bubble" style="--x: 16%; --size: 88px; --dur: 24s; --delay: -8s; --drift: -36px">
        <i class="bx bxs-stethoscope"></i>
      </div>
      <div class="icon-bubble" style="--x: 27%; --size: 58px; --dur: 20s; --delay: -10s; --drift: 30px">
        <i class="bx bxs-hospital"></i>
      </div>
      <div class="icon-bubble" style="--x: 38%; --size: 74px; --dur: 22s; --delay: -2s; --drift: -46px">
        <i class="bx bx-plus-medical"></i>
      </div>
      <div class="icon-bubble" style="--x: 50%; --size: 60px; --dur: 18s; --delay: -7s; --drift: 28px">
        <i class="bx bxs-heart"></i>
      </div>
      <div class="icon-bubble" style="--x: 61%; --size: 92px; --dur: 26s; --delay: -6s; --drift: 54px">
        <i class="bx bxs-hospital"></i>
      </div>
      <div class="icon-bubble" style="--x: 72%; --size: 64px; --dur: 19s; --delay: -5s; --drift: -24px">
        <i class="bx bxs-dog"></i>
      </div>
      <div class="icon-bubble" style="--x: 83%; --size: 84px; --dur: 23s; --delay: -7s; --drift: 40px">
        <i class="bx bxs-stethoscope"></i>
      </div>
      <div class="icon-bubble" style="--x: 93%; --size: 56px; --dur: 16s; --delay: -9s; --drift: -32px">
        <i class="bx bxs-plus-circle"></i>
      </div>
      <!-- many floating paw / plus / medical icons (more than before) -->
      <i class="bx bx-dog floating-particle particle-1"></i>
      <i class="bx bx-plus-circle floating-particle particle-2"></i>
      <i class="bx bx-plus-medical floating-particle particle-3"></i>
      <i class="bx bxs-dog floating-particle particle-4"></i>
      <i class="bx bxs-stethoscope floating-particle particle-5"></i>
      <i class="bx bxs-hospital floating-particle particle-6"></i>
      <i class="bx bx-heart-circle floating-particle particle-7"></i>
      <i class="bx bxs-dog floating-particle particle-8"></i>
      <!-- extra pet -->
      <i class="bx bxs-droplet-half floating-particle particle-9"></i>
      <!-- medical -->
    </div>

    <!-- main card -->
    <div class="authentication-wrapper">
      <div class="authentication-inner">
        <!-- LEFT PANEL: 100% PRESERVED (exact original, including badge) -->
        <div class="left-animated-panel">
          <div class="animated-dog-container">
            <i class="bx bxs-dog main-dog-icon"></i>
            <div class="float-icon ficon-left-1"><i class="bx bxs-plus-circle"></i></div>
            <div class="float-icon ficon-left-2"><i class="bx bxs-stethoscope"></i></div>
            <div class="float-icon ficon-left-3"><i class="bx bxs-dog"></i></div>
            <div class="float-icon ficon-left-4"><i class="bx bxs-heart"></i></div>
            <div class="left-bg-particles">
              <i class="bx bx-plus"></i>
              <i class="bx bx-plus"></i>
              <i class="bx bx-plus"></i>
            </div>
          </div>
          <!-- original left badge (exactly as provided) -->
          
        </div>

        <!-- RIGHT PANEL: COMPLETELY ANIMATED – perfect and attractive now -->
        <div class="right-form-panel">
          <div class="form-container">
            <!-- Goalf logo (with rich animation) -->
            <div class="goalf-logo d-flex justify-content-center">
                <img src="images/goal-foundation.png" alt="Goalf Logo" / width="150">
            </div>

            <h4>Welcome back, Admin 🐾</h4>
            <p class="subhead">Sign in to manage dogs, doctors & hospital</p>

            <form id="formAuthentication">
              <div class="mb-4">
                <label for="email" class="form-label">Email or Username</label>
                <input
                  type="text"
                  class="form-control"
                  id="email"
                  name="email-username"
                  placeholder="admin@goalf.org"
                  autofocus value="shakshipatel2gmail.com" />
              </div>

              <div class="mb-4 form-password-toggle">
                <label for="password" class="form-label">Password</label>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="password"
                    placeholder="············"
                    aria-describedby="password" value="12345678" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>

              <div class="my-4">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" id="remember-me" checked />
                    <label class="form-check-label" for="remember-me"> Remember me </label>
                  </div>
                  <a href="javascript:void(0);" class="forgot-link">Forgot password?</a>
                </div>
              </div>

              <button type="submit" class="btn-primary">Sign in</button>

              <!-- <p class="text-center mt-4 mb-3">
                <span>New to Goalf?</span>
                <a href="javascript:void(0);" class="forgot-link">Create account</a>
              </p>

              <div class="divider">
                <span class="divider-text">or continue with</span>
              </div>

              <div class="d-flex justify-content-center gap-2">
                <a href="javascript:;" class="btn-icon"><i class="bx bxl-facebook-circle"></i></a>
                <a href="javascript:;" class="btn-icon"><i class="bx bxl-twitter"></i></a>
                <a href="javascript:;" class="btn-icon"><i class="bx bxl-github"></i></a>
                <a href="javascript:;" class="btn-icon"><i class="bx bxl-google"></i></a>
              </div> -->
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- password toggle script (unchanged) -->
    <script>
      (function () {
        const authForm = document.getElementById('formAuthentication');
        if (authForm) {
          authForm.addEventListener('submit', function (e) {
            e.preventDefault();
            window.location.href = 'dashboard.html';
          });
        }

        document.querySelectorAll('.form-password-toggle .input-group-text').forEach(function (icon) {
          icon.addEventListener('click', function (e) {
            const input = this.closest('.input-group').querySelector('input');
            if (input.type === 'password') {
              input.type = 'text';
              this.innerHTML = '<i class="bx bx-show"></i>';
            } else {
              input.type = 'password';
              this.innerHTML = '<i class="bx bx-hide"></i>';
            }
          });
        });
      })();
    </script>
    <!-- badge pulse keyframe (exists in original, but we keep it – no left change) -->
    <style>
      /* ensure original left badge animation remains (was defined earlier but we inject missing keyframe if needed) */
      @keyframes badgePulse {
        0% {
          opacity: 0.8;
        }
        50% {
          opacity: 1;
          background: rgba(255, 255, 255, 0.8);
        }
        100% {
          opacity: 0.8;
        }
      }
    </style>
  </body>
</html>
