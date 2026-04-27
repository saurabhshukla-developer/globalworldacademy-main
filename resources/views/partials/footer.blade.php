{{-- ═══════════════════════════════
     Partial: Site Footer
     ═══════════════════════════════ --}}
<footer>
  <div class="footer-grid">

    {{-- Brand column --}}
    <div class="footer-brand">
      <div class="footer-logo">
        <div class="logo-mark-footer" aria-hidden="true">GW</div>
        <div class="logo-name-footer">Global <span>World</span> Academy</div>
      </div>
      <p>India's trusted online coaching platform for MPTET Varg 2 &amp; Varg 3 aspirants —
         expert video classes, test series &amp; free materials.</p>
      <div class="contact-line">
        📞 <a href="tel:+918770803840" style="color:inherit;">+91-8770803840</a>
      </div>
      <div class="footer-socials" style="margin-top:16px;">
        <a href="https://www.youtube.com/channel/UCAUjpk6WmdECWyGj90yl9Qg"
           target="_blank" rel="noopener" class="fsoc" aria-label="YouTube Channel">&#9654;</a>
        <a href="https://classplusapp.com/w/global-world-academy-xygeb"
           target="_blank" rel="noopener" class="fsoc" aria-label="Classplus App">📱</a>
        <a href="https://globalworldacademy.com"
           target="_blank" rel="noopener" class="fsoc" aria-label="Official Website">🌐</a>
      </div>
    </div>

    {{-- Courses column --}}
    <div class="footer-col">
      <h4>Courses</h4>
      <ul>
        <li><a href="https://classplusapp.com/w/global-world-academy-xygeb" target="_blank" rel="noopener">Varg 2 Science Mains</a></li>
        <li><a href="https://classplusapp.com/w/global-world-academy-xygeb" target="_blank" rel="noopener">Varg 3 PRE Test Series</a></li>
        <li><a href="https://classplusapp.com/w/global-world-academy-xygeb" target="_blank" rel="noopener">Varg 2 Science PRE 2026</a></li>
        <li><a href="https://classplusapp.com/w/global-world-academy-xygeb" target="_blank" rel="noopener">Varg 2 Full Length Tests</a></li>
        <li><a href="https://classplusapp.com/w/global-world-academy-xygeb" target="_blank" rel="noopener">View All &rarr;</a></li>
      </ul>
    </div>

    {{-- Free Resources column --}}
    <div class="footer-col">
      <h4>Free Resources</h4>
      <ul>
        <li><a href="{{ url('/') }}#quiz">Free MCQ Quiz</a></li>
        <li><a href="{{ route('quiz') }}">Daily Quiz Page</a></li>
        <li><a href="{{ url('/') }}#materials">Science Notes PDF</a></li>
        <li><a href="{{ url('/') }}#materials">Previous Year Papers</a></li>
        <li><a href="{{ url('/') }}#materials">CDP Summary Sheet</a></li>
      </ul>
    </div>

    {{-- Quick Links column --}}
    <div class="footer-col">
      <h4>Quick Links</h4>
      <ul>
        <li><a href="https://www.youtube.com/channel/UCAUjpk6WmdECWyGj90yl9Qg" target="_blank" rel="noopener">YouTube Channel</a></li>
        <li><a href="https://classplusapp.com/w/global-world-academy-xygeb" target="_blank" rel="noopener">Classplus App</a></li>
        <li><a href="{{ url('/') }}#faq">FAQ</a></li>
        <li><a href="tel:+918770803840">Contact Us</a></li>
        <li><a href="#">Privacy Policy</a></li>
      </ul>
    </div>

  </div>

  <div class="footer-bottom">
    <span>&copy; {{ date('Y') }} Global World Academy. All rights reserved.</span>
    <span>Made with &#10084;&#65039; for MPTET Aspirants across Madhya Pradesh</span>
  </div>
</footer>
