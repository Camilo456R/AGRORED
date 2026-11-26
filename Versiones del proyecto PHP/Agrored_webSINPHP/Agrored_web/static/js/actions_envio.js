    lucide.createIcons();

    document.addEventListener('DOMContentLoaded', () => {
      const shippingForm = document.querySelector('.shipping-form');
      const shippingOptions = document.querySelectorAll('.shipping-card-option');
      const btnCancel = document.querySelector('.btn-cancel');

      // Alternar selección visual de envío
      shippingOptions.forEach(option => {
        option.addEventListener('click', () => {
          shippingOptions.forEach(opt => opt.classList.remove('selected'));
          option.classList.add('selected');
          const radio = option.querySelector('input[type="radio"]');
          radio.checked = true;
        });
      });

      // Validar y procesar al hacer clic en "Continuar Envío"
      shippingForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const firstName = document.querySelector('input[placeholder="Primer nombre"]').value.trim();
        const lastName = document.querySelector('input[placeholder="Apellido"]').value.trim();
        const address = document.querySelector('input[placeholder="Dirección"]').value.trim();
        const department = document.querySelector('select').value;
        const municipality = document.querySelector('input[placeholder="Municipio"]').value.trim();
        const phone = document.querySelector('input[placeholder="Número de teléfono"]').value.trim();

        if (!firstName || !lastName || !address || !department || !municipality || !phone) {
          Swal.fire({
            icon: 'error',
            title: 'Faltan datos de envío',
            text: 'Por favor, diligencia todos los campos requeridos para coordinar la entrega.',
            confirmButtonColor: '#009900'
          });
          return;
        }

        Swal.fire({
          icon: 'success',
          title: '¡Dirección guardada!',
          html: `Tu pedido será enviado a <strong>${address}</strong> (${municipality}, ${department}).`,
          confirmButtonText: 'Continuar al Pago',
          confirmButtonColor: '#009900'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = 'pago.html';
          }
        });
      });

      // Acción para el botón "Cancelar"
      btnCancel.addEventListener('click', () => {
        Swal.fire({
          title: '¿Cancelar proceso de envío?',
          text: 'Se perderán los datos ingresados en el formulario.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#6e7881',
          confirmButtonText: 'Sí, cancelar',
          cancelButtonText: 'Volver al formulario'
        }).then((result) => {
          if (result.isConfirmed) {
            shippingForm.reset();
            Swal.fire({
              icon: 'info',
              title: 'Formulario limpiado',
              showConfirmButton: false,
              timer: 1500
            });
          }
        });
      });

      // Interactividad con el vale
      const couponRow = document.querySelector('.coupon-row');
      if (couponRow) {
        couponRow.addEventListener('click', async () => {
          const { value: couponCode } = await Swal.fire({
            title: 'Ingresa tu cupón',
            input: 'text',
            inputPlaceholder: 'Ej. AGRO2026',
            showCancelButton: true,
            confirmButtonColor: '#009900',
            cancelButtonText: 'Cancelar'
          });

          if (couponCode) {
            Swal.fire({
              icon: 'info',
              title: 'Validando vale...',
              text: `El cupón "${couponCode}" no es válido o ha expirado.`,
              confirmButtonColor: '#009900'
            });
          }
        });
      }
    });