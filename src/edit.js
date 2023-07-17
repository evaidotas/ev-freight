import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import './editor.scss';

export default function edit(props) {
	const {
		attributes: { numberSelection }
	} = props;

	const onChangeNumberSelection = (event) => {
		const value = parseInt(event.target.value, 10);
		props.setAttributes({ numberSelection: value });
	};

	return (
		<div {...useBlockProps()}>
			<label>
				{__('Number of freights to load', 'ev-freight')}
				<input
					type="number"
					value={numberSelection}
					onChange={onChangeNumberSelection}
					min={1}
					max={50}
				/>
			</label>
		</div>
	);
}
