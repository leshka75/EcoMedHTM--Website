/**
 * Cloudflare Pages Function — contact form handler
 * POST /submit
 */

export async function onRequestPost({ request, env }) {
  try {
    const data = await request.formData();

    const name    = (data.get('name')    || '').trim();
    const email   = (data.get('email')   || '').trim();
    const phone   = (data.get('phone')   || 'Not provided').trim();
    const subject = (data.get('subject') || 'Not specified').trim();
    const message = (data.get('message') || '').trim();

    if (!name || !email || !message) {
      return Response.json(
        { ok: false, error: 'Name, email and message are required.' },
        { status: 400 }
      );
    }

    // Turnstile spam check
    const token = data.get('cf-turnstile-response') || '';
    if (env.CF_TURNSTILE_SECRET && token) {
      const verify = await fetch('https://challenges.cloudflare.com/turnstile/v0/siteverify', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          secret: env.CF_TURNSTILE_SECRET,
          response: token,
          remoteip: request.headers.get('CF-Connecting-IP'),
        }),
      });
      const turnstileResult = await verify.json();
      console.log('Turnstile result:', JSON.stringify(turnstileResult));
      if (!turnstileResult.success) {
        return Response.json(
          { ok: false, error: 'Bot verification failed — please try again.' },
          { status: 400 }
        );
      }
    }

    // Send via Resend
    const res = await fetch('https://api.resend.com/emails', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${env.RESEND_API_KEY}`,
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        from: env.SEND_FROM,
        to: env.DEST_EMAIL,
        subject: `Contact form — ${subject}`,
        text: [
          'New contact form submission via ecomedhtm.com',
          '',
          `Name:    ${name}`,
          `Email:   ${email}`,
          `Phone:   ${phone}`,
          `Subject: ${subject}`,
          '',
          'Message:',
          message,
        ].join('\n'),
      }),
    });

    const resendResult = await res.json();
    console.log('Resend result:', JSON.stringify(resendResult));

    if (!res.ok) {
      throw new Error(resendResult.message || 'Resend error');
    }

    return Response.json({ ok: true });

  } catch (err) {
    console.error('Form submit error:', err.message || err);
    return Response.json(
      { ok: false, error: 'Submission failed — please try again or call us directly.' },
      { status: 500 }
    );
  }
}
