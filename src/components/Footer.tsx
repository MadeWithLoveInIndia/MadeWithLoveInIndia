import { Container } from '@/components/Container'
import { Logo } from '@/components/Logo'

export function Footer() {
  return (
    <footer className="flex-none py-16">
      <Container className="flex flex-col items-center justify-between md:flex-row">
        <Logo />
        <p className="mt-6 text-base text-slate-500 md:mt-0">
          <span>
            &copy; 2013–{new Date().getFullYear()} Made with Love in
            India&trade; by{' '}
            <a
              href="https://anandchowdhary.com?utm_source=mwlii&utm_medium=link&utm_campaign=footer"
              target="_blank"
              rel="noopener noreferrer"
              className="font-semibold hover:text-rose-500"
            >
              Anand Chowdhary
            </a>
          </span>
        </p>
      </Container>
    </footer>
  )
}
