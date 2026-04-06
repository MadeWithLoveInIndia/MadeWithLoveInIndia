import Image from 'next/image'

import { Button } from '@/components/Button'
import { Container } from '@/components/Container'
import { getStateName, states } from '@/data'
import backgroundImage from '@/images/background-newsletter.jpg'
import Link from 'next/link'

export function Newsletter() {
  return (
    <section id="newsletter" aria-label="Newsletter">
      <Container>
        <div className="mx-auto max-w-2xl py-32 text-center text-lg">
          <p className="text-4xl font-semibold tracking-tighter text-rose-900 sm:text-5xl">
            About the initiative
          </p>
          <p className="mt-8 tracking-tight text-rose-900">
            Imagine holding a meticulously crafted handicraft, its beauty
            evident in every detail. Yet, a label stating "Made in India" can
            sometimes inadvertently cast a shadow on its worth. Why does a "Made
            in Italy" label evoke a sense of luxury, irrespective of quality?
          </p>
          <p className="mt-4 tracking-tight text-rose-900">
            Now, picture that same exquisite handicraft in your hands once more.
            This time, a label reads "Made with love, in India." A warmth
            envelops you, and a smile graces your lips. It's a reminder that
            even small gestures hold immense power – the power to support local
            artisans and brighten someone's day. By embracing products{' '}
            <span className="font-semibold">
              Made with <span className="love">Love</span> in India
            </span>
            , you embrace the heart of a movement that champions entrepreneurs,
            enriches the economy, and spreads pride.
          </p>
          <p className="mt-4 tracking-tight text-rose-900">
            In every purchase, in every choice, you become a part of a tapestry
            woven with creativity, passion, and the indomitable spirit of India.
          </p>
          <Button href="/about" className="mt-4">
            Read our story
          </Button>
        </div>
        <div className="relative -mx-4 overflow-hidden bg-rose-50 px-4 py-20 sm:-mx-6 sm:px-6 md:mx-0 md:rounded-5xl md:px-16">
          <Image
            className="absolute left-1/2 top-0 translate-x-[-10%] translate-y-[-45%] lg:translate-x-[-32%]"
            src={backgroundImage}
            alt=""
            width={919}
            height={1351}
            unoptimized
          />
          <div className="relative mx-auto grid max-w-2xl grid-cols-1 gap-x-32 gap-y-14 xl:max-w-none xl:grid-cols-2">
            <div>
              <p className="text-4xl font-semibold tracking-tighter text-rose-900 sm:text-5xl">
                Questions?
              </p>
              <p className="mt-4 text-lg tracking-tight text-rose-900">
                If you want to know more about the initiative, have a press
                request, or want to learn more about licensing the brand, please
                get in touch.
              </p>
            </div>
            <div>
              <h3 className="text-lg font-semibold tracking-tight text-rose-900">
                Get in touch
              </h3>
              <p className="mt-4 text-lg tracking-tight text-rose-900">
                Send us an email at{' '}
                <a
                  href={`mailto:${'hello'}@${'madewithlove.org.in'}`}
                  className="font-semibold text-rose-600 underline hover:text-rose-800"
                >
                  hello (at) madewithlove.org.in
                </a>
              </p>
            </div>
          </div>
        </div>
        <div className="pt-20 sm:pt-32">
          <div className="grid grid-cols-2 gap-6 text-sm md:grid-cols-9">
            {states.map((state) => {
              const stateName = getStateName(state.slug)
              return (
                <div
                  key={state.slug}
                  className="relative space-y-3 leading-snug transition-opacity hover:opacity-80"
                >
                  <img
                    alt={`Monuments in ${stateName}`}
                    src={`https://tse2.mm.bing.net/th?q=${stateName}+India+monuments&w=700&h=400&c=7&rs=1&p=0&dpr=3&pid=1.7&mkt=en-IN&adlt=moderate`}
                    className="aspect-video w-full rounded-xl border object-cover shadow-lg"
                  />
                  <Link
                    href={`/${state.slug}`}
                    className="parent-relative-full-link flex truncate"
                  >
                    {stateName}
                  </Link>
                </div>
              )
            })}
          </div>
        </div>
      </Container>
    </section>
  )
}
