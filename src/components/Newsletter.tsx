import Image from 'next/image'

import { Button } from '@/components/Button'
import { Container } from '@/components/Container'
import { getStateName, states } from '@/data'
import backgroundImage from '@/images/background-newsletter.jpg'
import Link from 'next/link'

function ArrowRightIcon(props: React.ComponentPropsWithoutRef<'svg'>) {
  return (
    <svg aria-hidden="true" viewBox="0 0 24 24" {...props}>
      <path
        d="m14 7 5 5-5 5M19 12H5"
        fill="none"
        stroke="currentColor"
        strokeWidth="2"
        strokeLinecap="round"
        strokeLinejoin="round"
      />
    </svg>
  )
}

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
                use the form to get in touch.
              </p>
            </div>
            <form
              method="post"
              action="https://formspree.io/f/xrgwqvjz"
              target="_blank"
            >
              <h3 className="text-lg font-semibold tracking-tight text-rose-900">
                Get in touch <span aria-hidden="true">&darr;</span>
              </h3>
              <textarea
                name="message"
                className="mt-5 w-full resize-none rounded-4xl bg-white p-6 text-base text-slate-900 shadow-xl shadow-rose-900/5 placeholder:text-slate-400 focus-within:ring-2 focus:outline-none focus:ring-rose-900"
                placeholder="Message"
              />
              <div className="mt-5 flex rounded-4xl bg-white py-2.5 pr-2.5 shadow-xl shadow-rose-900/5 focus-within:ring-2 focus-within:ring-rose-900">
                <input
                  name="email"
                  type="email"
                  required
                  placeholder="Email address"
                  aria-label="Email address"
                  className="-my-2.5 flex-auto bg-transparent pl-6 pr-2.5 text-base text-slate-900 placeholder:text-slate-400 focus:outline-none"
                />
                <Button type="submit">
                  <span className="sr-only sm:not-sr-only">Send message</span>
                  <span className="sm:hidden">
                    <ArrowRightIcon className="h-6 w-6" />
                  </span>
                </Button>
              </div>
            </form>
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
