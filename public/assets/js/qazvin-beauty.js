(() => {
  const forms = [...document.querySelectorAll('[data-campaign-form]')];
  const params = new URLSearchParams(window.location.search);
  const attribution = {
    utm_source: params.get('utm_source') || '',
    utm_medium: params.get('utm_medium') || '',
    utm_campaign: params.get('utm_campaign') || '',
    campaign_key: 'qazvin_beauty_sms',
    landing_path: window.location.pathname,
  };

  const normalizePhone = (value) => value
    .replace(/[۰-۹]/g, (digit) => String('۰۱۲۳۴۵۶۷۸۹'.indexOf(digit)))
    .replace(/[٠-٩]/g, (digit) => String('٠١٢٣٤٥٦٧٨٩'.indexOf(digit)))
    .replace(/[\s()\-]/g, '');

  forms.forEach((form) => {
    const status = form.querySelector('.qb-form-status');
    const button = form.querySelector('[type="submit"]');
    form.addEventListener('submit', async (event) => {
      event.preventDefault();
      status.className = 'qb-form-status';
      status.textContent = '';
      const phoneField = form.elements.phone;
      const storeField = form.elements.store_identifier;
      const phone = normalizePhone(phoneField.value);
      const storeIdentifier = storeField.value.trim();
      phoneField.removeAttribute('aria-invalid');
      storeField.removeAttribute('aria-invalid');

      if (form.elements.website.value) return;
      if (!/^(?:\+98|0098|0)?9\d{9}$/.test(phone)) {
        phoneField.setAttribute('aria-invalid', 'true');
        status.textContent = 'شمارهٔ موبایل را کامل و درست وارد کنید؛ مثلاً ۰۹۱۲۳۴۵۶۷۸۹.';
        status.classList.add('is-error');
        phoneField.focus();
        return;
      }
      if (!storeIdentifier) {
        storeField.setAttribute('aria-invalid', 'true');
        status.textContent = 'آیدی اینستاگرام یا نام فروشگاه را وارد کنید.';
        status.classList.add('is-error');
        storeField.focus();
        return;
      }

      button.disabled = true;
      button.setAttribute('aria-busy', 'true');
      button.dataset.label = button.innerHTML;
      button.textContent = 'در حال ثبت درخواست…';
      try {
        const response = await fetch('/api/leads', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
          body: JSON.stringify({
            name: storeIdentifier,
            store_identifier: storeIdentifier,
            phone,
            service: 'marketing',
            details: 'درخواست تحلیل رایگان پیج و راهنمای فروش برای فروشگاه آرایشی یا بهداشتی قزوین؛ همراه با سه ایدهٔ ریلز متناسب با محصولات فروشگاه.',
            ...attribution,
          }),
        });
        const result = await response.json().catch(() => ({}));
        if (!response.ok) {
          const errors = result.errors ? Object.values(result.errors).flat() : [];
          throw new Error(errors[0] || result.message || 'ثبت درخواست انجام نشد. لطفاً دوباره تلاش کنید.');
        }
        form.reset();
        status.textContent = 'درخواست شما ثبت شد. به‌زودی برای هماهنگی تحلیل رایگان با شما تماس می‌گیریم.';
        status.classList.add('is-success');
      } catch (error) {
        status.textContent = error.message || 'اتصال برقرار نشد. لطفاً دوباره تلاش کنید یا تلفنی تماس بگیرید.';
        status.classList.add('is-error');
      } finally {
        button.disabled = false;
        button.removeAttribute('aria-busy');
        button.innerHTML = button.dataset.label || 'دریافت تحلیل رایگان پیج و راهنمای فروش';
      }
    });
  });

  const sticky = document.querySelector('.qb-sticky-cta');
  const firstForm = document.querySelector('#campaign-form');
  if (sticky && firstForm && 'IntersectionObserver' in window) {
    new IntersectionObserver(([entry]) => sticky.classList.toggle('is-hidden', entry.isIntersecting), { threshold: 0.18 }).observe(firstForm);
  }
})();
