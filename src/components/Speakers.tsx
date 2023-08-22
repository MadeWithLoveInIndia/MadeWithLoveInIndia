'use client'

import { Button } from '@/components/Button'
import { Container } from '@/components/Container'
import { Grid } from '@/components/Schedule'
import data from '@/generated/data.json'
import clsx from 'clsx'
import Link from 'next/link'
import React from 'react'

export function Speakers() {
  const [showAll, setShowAll] = React.useState(false)

  return (
    <section
      id="speakers"
      aria-labelledby="speakers-title"
      className="py-20 sm:py-32"
    >
      <Container>
        <div className="mx-auto max-w-2xl lg:mx-0">
          <h2
            id="speakers-title"
            className="font-display text-4xl font-semibold tracking-tighter text-rose-600 sm:text-5xl"
          >
            We&rsquo;re made in India.
          </h2>{' '}
          <p className="mb-12 mt-4 font-display text-2xl tracking-tight text-rose-900">
            Step into a world where every creation tells a story, and where Made
            with Love in India signifies not just a product's origin, but a
            testament to the nation's creativity, resilience, and unwavering
            spirit. Welcome to a celebration of India's innovation &mdash; where
            passion meets possibility.
          </p>
        </div>
        <Grid
          items={[
            {
              title: 'A badge of distinction',
              description:
                'When this badge graces a product or service, it carries with it a story of passion and purpose. It&rsquo;s a testament to the countless hours of tireless work, the spark of inspiration that ignited the idea, and the unwavering belief in the potential of Indian creativity.',
            },
            {
              title: 'Crafted with care',
              description:
                "Whether it's an artisanal creation, a technological breakthrough, or a game-changing service, Made with Love in India encapsulates the very essence of what makes this nation remarkable. It signifies that you're holding a piece of India's soul in your hands – a fusion of heritage and innovation.",
            },
            {
              title: 'Empowering dreams',
              description:
                "With every Made with Love in India badge, you're part of something bigger. You're supporting the dreams of entrepreneurs who dared to dream, who took the road less traveled, and who are now shaping industries and leaving their mark on the world.",
            },
          ]}
        />
        <div
          className={clsx(
            'relative',
            showAll ? '' : 'max-h-[400px] overflow-hidden',
          )}
        >
          {!showAll && (
            <>
              <div className="pointer-events-none absolute bottom-0 left-0 right-0 z-20 flex h-64 items-end justify-center bg-gradient-to-b from-transparent to-white" />
              <div className="absolute bottom-0 left-0 right-0 z-30 flex items-center justify-center">
                <Button onClick={() => setShowAll((val) => !val)}>
                  Show all
                </Button>
              </div>
            </>
          )}
          <div className="mt-20 grid gap-16 md:grid-cols-4">
            {[
              ...data,
              ...data,
              ...data,
              ...data,
              ...data,
              ...data,
              ...data,
              ...data,
              ...data,
              ...data,
              ...data,
              ...data,
              ...data,
              ...data,
              ...data,
              ...data,
              ...data,
              ...data,
              ...data,
              ...data,
              ...data,
              ...data,
              ...data,
            ].map((item, index) => (
              <div
                key={`${item.slug}_${index}`}
                className="relative flex transition-opacity hover:opacity-70"
              >
                <div className="mr-4 flex h-16 w-16 shrink-0 items-center justify-center rounded-xl shadow">
                  <img
                    alt=""
                    src={
                      'github' in item && item.github
                        ? `https://github.com/${item.github}.png?size=200`
                        : 'url' in item && typeof item.url === 'string'
                        ? `https://logo.clearbit.com/${
                            new URL(item.url).hostname
                          }`
                        : ''
                    }
                    className="rounded-xl"
                  />
                </div>
                <div className="col-span-3 grow space-y-1">
                  {'name' in item && typeof item.name === 'string' && (
                    <div className="font-semibold">
                      <Link
                        className="parent-relative-full-link"
                        href={`/${item.slug}`}
                      >
                        {item.name}
                      </Link>
                    </div>
                  )}
                  {'tagline' in item && typeof item.tagline === 'string' && (
                    <p className="text-sm leading-snug text-slate-500">
                      {item.tagline}
                    </p>
                  )}
                </div>
              </div>
            ))}
          </div>
        </div>
      </Container>
    </section>
  )
}
