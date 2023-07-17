import { useBlockProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import './editor.scss';

export default function save({ attributes }) {
	const { numberSelection } = attributes;

	return (
		<div {...useBlockProps.save()}>
			<label>
				{__('Number of freights to load', 'ev-freight')}
				<input
					type="number"
					value={numberSelection}
					min={1}
					max={50}
				/>
			</label>
		</div>
	);
}
