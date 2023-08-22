import { BackgroundImage } from '@/components/BackgroundImage'
import { Container } from '@/components/Container'

export function Grid({
  items,
}: {
  items: { title: React.ReactNode; description: React.ReactNode }[]
}) {
  return (
    <div className="grid gap-12 lg:grid-cols-3">
      {items.map((item, index) => (
        <article className="space-y-2" key={index}>
          <h4 className="font-display text-xl font-semibold tracking-tight text-rose-900">
            {item.title}
          </h4>
          <p>{item.description}</p>
        </article>
      ))}
    </div>
  )
}

function Code() {
  return (
    <div className="overflow-x-auto whitespace-nowrap rounded-lg bg-white/60 p-8 text-center font-mono shadow-xl shadow-rose-900/5 backdrop-blur">
      &lt;a href="https://madewithlove.org.in" target="_blank"&gt;Made with
      &lt;span aria-label="Love" style="color:
      #f43f5e"&gt;&amp;hearts;&lt;/span&gt; in India&lt;/a&gt;
    </div>
  )
}

export function Schedule() {
  return (
    <section id="join" aria-label="Schedule" className="py-20 sm:py-32">
      <Container className="relative z-10">
        <div className="mx-auto max-w-2xl lg:mx-0 lg:max-w-4xl lg:pr-24">
          <h2 className="font-display text-4xl font-semibold tracking-tighter text-rose-600 sm:text-5xl">
            Join the movement.
          </h2>
          <p className="mt-4 font-display text-2xl tracking-tight text-rose-900">
            If you use the Made with Love in India badge in your startup or
            project’s website or products, submit it and get featured on our
            platform.
          </p>
          <p className="mt-4 font-display text-2xl tracking-tight text-rose-900">
            Copy and paste the following code in your footer:
          </p>
        </div>
      </Container>
      <div className="relative mt-14 sm:mt-24">
        <BackgroundImage position="right" className="-bottom-32 -top-40" />
        <Container className="relative">
          <Code />
          <p className="mt-14 font-display text-2xl tracking-tight text-rose-900 sm:mt-24">
            Once you have added the badge, follow the{' '}
            <a
              href="https://github.com/MadeWithLoveInIndia/madewithlove.org.in#join-the-movement"
              target="_blank"
              rel="noopener noreferrer"
              className="font-semibold hover:text-rose-500"
            >
              Contributing guidelines
            </a>{' '}
            on in our open-source repository on GitHub to add a link to your
            website to our collection. Make a pull request and we’ll merge it!
          </p>
          <div className="mx-auto max-w-2xl lg:mx-0 lg:max-w-4xl lg:pr-24">
            <h3 className="font-display text-3xl font-semibold tracking-tighter text-rose-600 sm:mt-24">
              Responsibilities
            </h3>
            <p className="mb-12 mt-4 font-display text-2xl tracking-tight text-rose-900">
              We hold a deep commitment to both our nation's heritage and her
              future. As stewards of this movement, we embrace a set of
              responsibilities that reflect our dedication to upholding the
              values of respect, inclusivity, and ethical conduct.
            </p>
          </div>
          <Grid
            items={[
              {
                title: 'Respecting our identity',
                description:
                  "We pledge never to use our nation's name, flag, or symbols in any way that disrespects or diminishes their significance. Our pride in India's cultural richness is woven into everything we do, and we ensure that our actions align with the honor and dignity they deserve.",
              },
              {
                title: 'Embracing diversity and inclusivity',
                description:
                  "Just as India is a tapestry of cultures, languages, and traditions, we strive to make our products and services accessible and inclusive to all. We're committed to breaking down barriers and creating opportunities that resonate with people from every corner of our diverse nation.",
              },
              {
                title: 'Contributing to growth',
                description:
                  'As responsible citizens, we recognize the importance of contributing to the well-being of our nation. We commit to paying our fair share of taxes, thereby actively participating in the growth and development of our country. Our success is intertwined with the prosperity of India, and we embrace this responsibility wholeheartedly.',
              },
              {
                title: 'Sustaining ethical practices',
                description:
                  'Integrity forms the cornerstone of our endeavors. We promise to maintain the highest standards of ethical conduct, treating our partners, customers, and stakeholders with fairness and honesty. Our Made with Love in India community is built on trust, and we nurture it with every decision we make.',
              },
              {
                title: 'Supporting local communities',
                description:
                  'Just as we champion entrepreneurs and startups across India, we also extend our support to local communities. Through collaborations and initiatives, we aim to uplift the regions that inspire our creations, contributing to their social and economic well-being.',
              },
              {
                title: 'Empowering creators',
                description:
                  "Our responsibility extends to the very heart of our movement – the creators. We vow to empower the dreamers and visionaries who breathe life into their ideas. By providing a platform that nurtures their potential, we help them realize their aspirations and drive India's entrepreneurial spirit forward.",
              },
            ]}
          />
        </Container>
      </div>
    </section>
  )
}
