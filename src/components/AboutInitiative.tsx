import { Button } from '@/components/Button'
import { Container } from '@/components/Container'

export function AboutInitiative() {
  return (
    <section id="about-initiative" aria-label="About the initiative">
      <Container>
        <div className="mx-auto max-w-2xl py-32 text-center text-lg">
          <p className="text-4xl font-semibold tracking-tighter text-rose-900 sm:text-5xl">
            About the initiative
          </p>
          <p className="mt-8 tracking-tight text-rose-900">
            Imagine holding a meticulously crafted handicraft, its beauty
            evident in every detail. Yet, a label stating "Made in India" can
            sometimes inadvertently cast a shadow on its worth. Why does a
            "Made in Italy" label evoke a sense of luxury, irrespective of
            quality?
          </p>
          <p className="mt-4 tracking-tight text-rose-900">
            Now, picture that same exquisite handicraft in your hands once more.
            This time, a label reads "Made with love, in India." A warmth
            envelops you, and a smile graces your lips. It's a reminder that
            even small gestures hold immense power - the power to support local
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
      </Container>
    </section>
  )
}
