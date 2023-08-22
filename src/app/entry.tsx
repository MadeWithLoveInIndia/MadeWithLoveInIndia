import { BackgroundImage } from '@/components/BackgroundImage'
import { Container } from '@/components/Container'
import { Sponsors } from '@/components/Sponsors'

export default function Entry({ data }: { data: any }) {
  return (
    <>
      <div className="relative pt-20 sm:pt-36">
        <BackgroundImage position="right" className="-bottom-14 -top-36" />
        <Container className="relative">
          <div className="max-w-2xl lg:max-w-4xl">
            <h1 className="font-display text-5xl font-bold tracking-tighter sm:text-7xl">
              {data.name}
            </h1>
            {data.description && (
              <div className="mt-6 space-y-6 font-display text-2xl tracking-tight text-rose-900">
                <p>{data.description}</p>
              </div>
            )}
          </div>
        </Container>
      </div>
      <Sponsors />
    </>
  )
}
