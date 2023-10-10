import { BackgroundImage } from '@/components/BackgroundImage'
import { Button } from '@/components/Button'
import { Container } from '@/components/Container'
import data from '@/generated/data.json'
import Link from 'next/link'

export function Hero() {
  return (
    <div className="relative py-20 sm:pb-24 sm:pt-36">
      <BackgroundImage position="right" className="-bottom-14 -top-36" />
      <Container className="relative">
        <div className="max-w-2xl lg:max-w-4xl">
          <h1 className="font-display text-5xl font-bold tracking-tighter sm:text-7xl">
            <span className="sr-only">Made with Love in India - </span>A
            movement to celebrate, promote, and build a brand —{' '}
            <span className="text-rose-600">India</span>.
          </h1>
          <div className="mt-6 space-y-6 font-display text-2xl tracking-tight text-rose-900">
            <p>
              At the crossroads of tradition and innovation, where creativity
              flourishes and entrepreneurship thrives, lies a remarkable
              movement &mdash; Made with Love in India. Rooted in the heart of
              this diverse nation, our mission is to spotlight the incredible
              stories, talents, and endeavors that define the spirit of
              India&rsquo;s entrepreneurial landscape.
            </p>
            <p>
              Next time you see the{' '}
              <strong>
                Made with <span className="love">Love</span> in India
              </strong>{' '}
              badge on a product, know that you&rsquo;re not just looking at a
              symbol &mdash; you&rsquo;re witnessing a commitment to excellence,
              a dedication to craft, and a journey of innovation that spans the
              length and breadth of this incredible nation.
            </p>
          </div>
          <Button href="/#join" className="mt-10 w-full sm:hidden">
            Join the movement
          </Button>
          <dl className="mt-10 grid grid-cols-2 gap-x-10 gap-y-6 sm:mt-16 sm:gap-x-16 sm:gap-y-10 sm:text-center lg:auto-cols-auto lg:grid-flow-col lg:grid-cols-none lg:justify-start lg:text-left">
            {[
              [
                'Companies',
                data.filter((i) => i.type === 'company').length,
                '/companies',
              ],
              [
                'Projects',
                data.filter((i) => i.type === 'open source project').length,
                '/open-source-projects',
              ],
              [
                'People',
                data.filter((i) => i.type === 'personal website').length,
                '/personal-websites',
              ],
              ['Founded', '2013'],
            ].map(([name, value, href]) =>
              typeof href === 'string' ? (
                <Link
                  href={href}
                  key={name}
                  className="rounded-lg hover:opacity-50 focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-500"
                >
                  <dt className="font-mono text-sm text-rose-600">{name}</dt>
                  <dd className="mt-0.5 text-2xl font-semibold tracking-tight text-rose-900">
                    {value}
                  </dd>
                </Link>
              ) : (
                <div key={name}>
                  <dt className="font-mono text-sm text-rose-600">{name}</dt>
                  <dd className="mt-0.5 text-2xl font-semibold tracking-tight text-rose-900">
                    {value}
                  </dd>
                </div>
              ),
            )}
          </dl>
        </div>
      </Container>
    </div>
  )
}
