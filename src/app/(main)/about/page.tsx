import { BackgroundImage } from '@/components/BackgroundImage'
import { Button } from '@/components/Button'
import { Container } from '@/components/Container'
import { Sponsors } from '@/components/Sponsors'
import { type Metadata } from 'next'

export const metadata: Metadata = {
  openGraph: {
    images: `https://v1.screenshot.11ty.dev/${encodeURIComponent(
      'https://madewithloveinindia.org/about',
    )}/opengraph`,
  },
}

export default function About() {
  return (
    <>
      <div className="relative pt-20 sm:pt-36">
        <BackgroundImage position="right" className="-bottom-14 -top-36" />
        <Container className="relative">
          <div className="max-w-2xl lg:max-w-4xl">
            <h1 className="font-display text-5xl font-bold tracking-tighter sm:text-7xl">
              About
            </h1>
            <div className="mt-6 space-y-6 font-display text-2xl tracking-tight text-rose-900">
              <p>
                In a world where products are often seen as mere commodities, we
                invite you to embark on a journey that transforms the act of
                choosing into a celebration of artistry, creativity, and
                community. Welcome to{' '}
                <strong className="font-semibold">
                  Made with <span className="love">Love</span> in India
                </strong>
                , a platform that redefines the way we perceive and appreciate
                products, one beautifully crafted creation at a time.
              </p>
            </div>
            <Button href="/#join" className="mt-10 w-full sm:hidden">
              Join the movement
            </Button>
          </div>
        </Container>
      </div>
      <Container className="relative py-12">
        <div className="max-w-2xl space-y-8 text-lg lg:max-w-4xl">
          <p>
            Picture this: you're holding a meticulously made handicraft item,
            its intricate details capturing your imagination. As you marvel at
            the craftsmanship, a label catches your eye: "Made in India." A
            thought flickers – why does this label sometimes evoke uncertainty
            about quality, overshadowing the dedication that went into its
            creation? In contrast, the phrase "Made in Italy" seems to bestow an
            instant aura of elegance and refinement. Our journey began with a
            desire to change this perception. We pondered over the power of
            words, the resonance they hold, and the stories they tell. And thus,
            Made with Love in India was born – a phrase that encapsulates not
            just the origin of a product but the essence of passion, dedication,
            and the vibrant culture that it embodies.
          </p>
          <p>
            Now, reimagine that finely crafted handicraft in your hands. As you
            examine it closely, a label reveals itself: "Made with love, in
            India." Suddenly, a warmth envelops you, and a smile finds its way
            to your lips. It's a label that speaks of something more – of the
            heart and soul poured into every creation, of the dreams of artisans
            and entrepreneurs who dare to dream big. Our platform celebrates
            this transformative power of language and perception. We believe
            that a simple shift in perspective can brighten someone's day,
            inspire change, and remind us all that every choice we make has an
            impact.
          </p>
          <h2 className="pt-8 font-display text-3xl font-semibold tracking-tighter text-rose-600">
            Championing local makers
          </h2>
          <p>
            Made with Love in India isn't just about products; it's about
            people. We're dedicated to shining a spotlight on the countless
            talented artisans, creators, and entrepreneurs who breathe life into
            their visions. With each creation, they infuse a piece of themselves
            into their work, enriching our lives and communities. By choosing
            products from our platform, you become a patron of creativity, a
            supporter of dreams, and an advocate for the vibrancy of local
            economies. You contribute to a narrative that extends beyond
            products – one that tells stories of resilience, innovation, and the
            spirit of entrepreneurship that defines India.
          </p>
          <p>
            Every time you see the{' '}
            <strong>
              Made with <span className="love">Love</span> in India
            </strong>{' '}
            badge, let it be a reminder of the stories it carries – of artisans'
            dedication, dreams turned into reality, and the collective effort
            that powers our nation's growth. We invite you to explore our
            platform, discover exceptional products, and become a part of a
            movement that's redefining how we perceive quality, value, and the
            impact of our choices. In embracing the Made with Love in India
            philosophy, you become a catalyst for change. You become a supporter
            of creators, a contributor to communities, and a bearer of a legacy
            that intertwines innovation with tradition. Together, let's
            celebrate the heart of India – one product, one choice, and one
            story at a time.
          </p>
          <h2 className="pt-8 font-display text-3xl font-semibold tracking-tighter text-rose-600">
            A decade of impact
          </h2>
          <p>
            I (Anand) came up with the Made with Love in India initiative in
            April 2013 in Kechala, Odisha, and asked all the founders I knew to
            add the badge on their products, quickly creating a website to list
            them. This simple list evolved into a badge of honor worn by some
            great books, t-shirts, software, and everything in between. Our
            journey has been more than just products – it's been about shaping
            narratives, challenging stereotypes, and inspiring change. The shift
            from Made in India to Made with Love in India represents not just a
            linguistic distinction, but a paradigm shift in how we perceive
            value, quality, and the impact of our choices. It's been a decade of
            sparking conversations, fostering pride, and reminding us all of the
            remarkable potential within our nation's borders.
          </p>
          <p>Thank you for visiting!</p>
        </div>
      </Container>
      <Sponsors />
    </>
  )
}
