export function Logo(props: React.ComponentPropsWithoutRef<'svg'>) {
  return (
    <div className="text-2xl font-semibold">
      Made with{' '}
      <span aria-label="Love" className="font-display">
        &hearts;
      </span>{' '}
      in India
    </div>
  )
}
