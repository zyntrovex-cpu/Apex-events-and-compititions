    </div>
  </section>
</div>
<div class="admin-backdrop" data-admin-backdrop aria-hidden="true"></div>
<script src="<?= e($siteBase) ?>assets/js/main.js" defer></script>
<script>
(function(){
  var toggle = document.querySelector('[data-admin-menu]');
  var side = document.getElementById('admin-side');
  var backdrop = document.querySelector('[data-admin-backdrop]');
  if (!toggle || !side) return;
  function setOpen(v){
    document.body.classList.toggle('admin-nav-open', v);
    toggle.setAttribute('aria-expanded', String(v));
  }
  toggle.addEventListener('click', function(){ setOpen(!document.body.classList.contains('admin-nav-open')); });
  if (backdrop) backdrop.addEventListener('click', function(){ setOpen(false); });
  side.addEventListener('click', function(e){ if (e.target.tagName === 'A') setOpen(false); });
})();
</script>
</body>
</html>
