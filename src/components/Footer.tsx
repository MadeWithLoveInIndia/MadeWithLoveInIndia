import { Container } from '@/components/Container'
import {
  IconBrandFacebook,
  IconBrandGithub,
  IconBrandTwitter,
} from '@tabler/icons-react'

export function Footer() {
  return (
    <footer className="flex-none pb-16">
      <Container className="flex flex-col items-center justify-between">
        <div className="mb-12">
          <p className="text-center text-base text-slate-500">
            &trade; &amp; &copy; 2013–{new Date().getFullYear()}
          </p>
          <div className="mt-4 flex items-center justify-center space-x-4 text-slate-500">
            <a
              href="https://www.facebook.com/MadeWithLoveInIndia"
              target="_blank"
              rel="noopener noreferrer"
              className="opacity-80 transition-opacity hover:opacity-100"
            >
              <IconBrandFacebook className="h-6 w-6" strokeWidth={1.5} />
            </a>
            <a
              href="https://twitter.com/mwlii"
              target="_blank"
              rel="noopener noreferrer"
              className="opacity-80 transition-opacity hover:opacity-100"
            >
              <IconBrandTwitter className="h-6 w-6" strokeWidth={1.5} />
            </a>
            <a
              href="https://github.com/MadeWithLoveInIndia"
              target="_blank"
              rel="noopener noreferrer"
              className="opacity-80 transition-opacity hover:opacity-100"
            >
              <IconBrandGithub className="h-6 w-6" strokeWidth={1.5} />
            </a>
          </div>
        </div>
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
