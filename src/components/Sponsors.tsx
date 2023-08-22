import { Container } from '@/components/Container'

export function Sponsors() {
  return (
    <section
      id="sponsors"
      aria-label="Sponsors"
      className="flex justify-center pb-8 pt-20"
    >
      <Container>
        <p className="mb-4 text-center">A not-for-profit initiative by</p>
        <a
          href="https://chowdhary.org?utm_source=mwlii&utm_medium=link&utm_campaign=footer"
          target="_blank"
          rel="noopener noreferrer"
        >
          <img
            alt="Chowdhary.org"
            src="https://chowdhary.org/logo.6caa8563.svg"
            className="w-64"
          />
        </a>
      </Container>
    </section>
  )
}
