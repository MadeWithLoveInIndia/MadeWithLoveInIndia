import { Container } from '@/components/Container'

export function Footer() {
  return (
    <footer className="flex-none pb-16">
      <Container className="flex flex-col items-center justify-between">
        <p className="text-base text-slate-500">
          &trade; &amp; &copy; 2013–{new Date().getFullYear()}
        </p>
        <p className="text-base text-slate-500">
          Made with <span className="love">Love</span> in India by{' '}
          <a
            href="https://anandchowdhary.com?utm_source=mwlii&utm_medium=link&utm_campaign=footer"
            target="_blank"
            rel="noopener noreferrer"
            className="font-semibold hover:text-rose-500"
          >
            Anand Chowdhary
          </a>
        </p>
      </Container>
    </footer>
  )
}
